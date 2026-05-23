<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Mensajeria;
use App\Models\Persona;
use App\Mail\MensajeEnviado;

class MensajeriaController extends Controller
{

    public function index(Request $request)
    {
        $usuario = Auth::user();
        $rol = $usuario->persona->tipoPersona->tipo_persona;

        $query = Mensajeria::with('cliente','empleado');

        if ($rol !== 'administrador') {
            $query->where('usuario_reg',$usuario->id);
        }

        $perPage = $request->get('per_page',10);

        $mensajes = $query
            ->orderBy('registrado','asc')
            ->paginate($perPage);

        $clientes = Persona::all();

        return view('mensajeria.index',compact('mensajes','clientes'));
    }


    public function store(Request $request)
    {
        $usuario = Auth::user();
        $rol = $usuario->persona->tipoPersona->tipo_persona;

        if (!in_array($rol,['administrador','abogado','secretaria','cliente'])) {
            abort(403,'No tienes permiso para enviar mensajes.');
        }

        $request->validate([
            'id_cliente' => 'required|exists:personas,id',
            'asunto' => 'required|string|max:150',
            'mensaje' => 'required|string',
        ]);

        // IMPORTANTE: el mensaje inicia como NO enviado
        Mensajeria::create([
            'id_cliente'   => $request->id_cliente,
            'id_empleado'  => $usuario->persona_id,
            'asunto'       => $request->asunto,
            'mensaje'      => $request->mensaje,
            'usuario_reg'  => $usuario->id,
            'estado'       => false, // WhatsApp NO enviado
            'registrado'   => now(),
            'enviado_email'=> false, // Email NO enviado
        ]);

        return redirect()->route('mensajeria.index')
            ->with('success','Mensaje guardado correctamente.');
    }



    public function enviarWhatsApp($id)
    {
        $mensaje = Mensajeria::with('cliente')->findOrFail($id);

        if (!$mensaje->cliente || !$mensaje->cliente->celular) {
            return back()->with('error','El cliente no tiene número de celular.');
        }

        $numero = preg_replace('/\D/','',$mensaje->cliente->celular);

        if (strpos($numero,'591') !== 0) {
            $numero = '591'.$numero;
        }

        // marcar como enviado por WhatsApp
        $mensaje->update([
            'estado' => true
        ]);

        $texto = urlencode($mensaje->mensaje);

        return redirect()->away("https://wa.me/{$numero}?text={$texto}");
    }



    public function enviarEmail($id)
{
    $mensaje = Mensajeria::with('cliente')->findOrFail($id);

    if (!$mensaje->cliente || !$mensaje->cliente->email) {
        return back()->with('error','El cliente no tiene correo registrado.');
    }

    try {

        Mail::to($mensaje->cliente->email)
            ->send(new MensajeEnviado($mensaje));

        $mensaje->update([
            'enviado_email' => true,
            'fecha_envio_email' => now()
        ]);

        return back()->with('success','Correo enviado correctamente.');

    } catch (\Exception $e) {

        return back()->with('error','Error al enviar el correo.');

    }
}

}
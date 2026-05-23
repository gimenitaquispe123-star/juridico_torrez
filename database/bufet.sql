-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-09-2025 a las 05:40:07
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bufet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actuaciones`
--

CREATE TABLE `actuaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `participante_id` bigint(20) UNSIGNED NOT NULL,
  `fue_citado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_citacion` date DEFAULT NULL,
  `tipo_actuacion` varchar(255) DEFAULT NULL,
  `descripcion_actuacion` text DEFAULT NULL,
  `documento_adjunto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acusaciones_rapidas`
--

CREATE TABLE `acusaciones_rapidas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asignacion_institucional_id` bigint(20) UNSIGNED NOT NULL,
  `procedimiento_inmediato_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_delito` varchar(255) DEFAULT NULL,
  `acusacion_pdf` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acusacion_evidencia`
--

CREATE TABLE `acusacion_evidencia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `acusacion_rapida_id` bigint(20) UNSIGNED NOT NULL,
  `evidencia_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adopciones`
--

CREATE TABLE `adopciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `solicitante1_id` bigint(20) UNSIGNED NOT NULL,
  `solicitante2_id` bigint(20) UNSIGNED DEFAULT NULL,
  `id_abogado` bigint(20) UNSIGNED NOT NULL,
  `tienen_hijos` tinyint(1) DEFAULT NULL,
  `cantidad_hijos` int(11) DEFAULT NULL,
  `fecha_entrevista` date NOT NULL,
  `diferencia_nna` int(11) DEFAULT NULL,
  `motivo_adopcion` text DEFAULT NULL,
  `estado` enum('Iniciado','En evaluación','Idóneo','En proceso judicial','Finalizado') NOT NULL DEFAULT 'Iniciado',
  `correo_procesal` varchar(255) DEFAULT NULL,
  `domicilio_procesal` varchar(255) DEFAULT NULL,
  `rpa` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agendas`
--

CREATE TABLE `agendas` (
  `id_agenda` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo_evento` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time DEFAULT NULL,
  `lugar` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Programado',
  `prioridad` varchar(255) NOT NULL DEFAULT 'Media',
  `notificar` tinyint(1) NOT NULL DEFAULT 0,
  `documento` varchar(255) DEFAULT NULL,
  `abogado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anotaciones`
--

CREATE TABLE `anotaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asistencia_id` bigint(20) UNSIGNED NOT NULL,
  `abogado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contenido` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apelaciones`
--

CREATE TABLE `apelaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sentencia_inmediata_id` bigint(20) UNSIGNED NOT NULL,
  `se_apela` varchar(255) NOT NULL,
  `plazo_apelacion` date DEFAULT NULL,
  `motivo_recurso` text DEFAULT NULL,
  `documento_apelacion` varchar(255) DEFAULT NULL,
  `tribunal_alzada` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apelacions`
--

CREATE TABLE `apelacions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guarda_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_resolucion` date NOT NULL,
  `juzgado` varchar(255) NOT NULL,
  `menor_nombre` varchar(255) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `num_resolucion` varchar(255) NOT NULL,
  `resumen_resolucion` text NOT NULL,
  `motivo_apelacion` text NOT NULL,
  `petitorio` text NOT NULL,
  `pruebas_documentales` text DEFAULT NULL,
  `pruebas_testimoniales` text DEFAULT NULL,
  `pruebas_periciales` text DEFAULT NULL,
  `otrosi_digo` text DEFAULT NULL,
  `ciudad` varchar(255) NOT NULL,
  `fecha_presentacion` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_reconocimiento`
--

CREATE TABLE `archivos_reconocimiento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reconocimiento_id` bigint(20) UNSIGNED NOT NULL,
  `nombre_original` varchar(255) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `tamano` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_institucionales`
--

CREATE TABLE `asignaciones_institucionales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_inmediato_id` bigint(20) UNSIGNED NOT NULL,
  `fiscal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `juez_id` bigint(20) UNSIGNED DEFAULT NULL,
  `numero_caso` varchar(255) DEFAULT NULL,
  `tipo_delito` varchar(255) DEFAULT NULL,
  `tiene_expediente` tinyint(1) NOT NULL DEFAULT 0,
  `numero_expediente` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `demandante_id` bigint(20) UNSIGNED DEFAULT NULL,
  `demandado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `relacion_con_demandado` enum('Padre','Madre','Cónyuge','Hijo/a','Otro') DEFAULT NULL,
  `tipo_asistencia` enum('Prenatal','Ordinaria','Conyuge','Adulto Mayor','Modificación') NOT NULL DEFAULT 'Prenatal',
  `observaciones_abogado` text DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_adulto`
--

CREATE TABLE `asistencia_adulto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asistencia_id` bigint(20) UNSIGNED NOT NULL,
  `juzgado_competente` varchar(255) DEFAULT NULL,
  `estado_salud` varchar(255) DEFAULT NULL,
  `descripcion_hechos` text DEFAULT NULL,
  `articulos_referenciados` text DEFAULT NULL,
  `monto_asistencia` decimal(10,2) NOT NULL,
  `forma_pago` enum('Mensual','Quincenal','Otro') NOT NULL,
  `forma_pago_otro` varchar(255) DEFAULT NULL,
  `duracion_asistencia` enum('Temporal','Indefinida') NOT NULL,
  `duracion_detalle` varchar(255) DEFAULT NULL,
  `copia_ci_demandante` tinyint(1) NOT NULL DEFAULT 0,
  `certificado_medico` tinyint(1) NOT NULL DEFAULT 0,
  `documentos_gastos` text DEFAULT NULL,
  `informe_social` tinyint(1) NOT NULL DEFAULT 0,
  `testigos` text DEFAULT NULL,
  `otros_medios_probatórios` text DEFAULT NULL,
  `solicitud_audiencia` text DEFAULT NULL,
  `ciudad` varchar(255) NOT NULL,
  `fecha_firma` date NOT NULL,
  `firma_demandante` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_conyuge`
--

CREATE TABLE `asistencia_conyuge` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asistencia_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_matrimonio` date DEFAULT NULL,
  `registro_civil_numero` varchar(255) DEFAULT NULL,
  `registro_civil_municipio` varchar(255) DEFAULT NULL,
  `fecha_separacion` date DEFAULT NULL,
  `monto_solicitado` decimal(10,2) DEFAULT NULL,
  `medio_pago` varchar(255) DEFAULT NULL,
  `lugar_domicilio_procesal` varchar(255) DEFAULT NULL,
  `lugar_demanda` varchar(255) DEFAULT NULL,
  `fecha_demanda` date DEFAULT NULL,
  `fundamento_legal` text DEFAULT NULL,
  `petitorio` text DEFAULT NULL,
  `pruebas_ofrecidas` text DEFAULT NULL,
  `otrosis_1` text DEFAULT NULL,
  `otrosis_2` text DEFAULT NULL,
  `domicilio_procesal` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_familiar`
--

CREATE TABLE `asistencia_familiar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero_proceso` varchar(255) NOT NULL,
  `nombre_demandante` varchar(255) NOT NULL,
  `nombre_beneficiario` varchar(255) NOT NULL,
  `tipo_asistencia` enum('Prenatal','Ordinaria','Conyuge','Adulto Mayor','Modificación') NOT NULL,
  `monto_solicitado` decimal(10,2) DEFAULT NULL,
  `juzgado` varchar(255) NOT NULL,
  `abogado_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_ordinaria`
--

CREATE TABLE `asistencia_ordinaria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asistencia_id` bigint(20) UNSIGNED NOT NULL,
  `parentesco` enum('Hijo biológico','Adoptado') NOT NULL DEFAULT 'Hijo biológico',
  `motivo` text DEFAULT NULL,
  `hechos` text DEFAULT NULL,
  `fundamentos_derecho` text DEFAULT NULL,
  `petitorio` text DEFAULT NULL,
  `medios_prueba` text DEFAULT NULL,
  `anexos` text DEFAULT NULL,
  `lugar_demanda` varchar(255) DEFAULT NULL,
  `fecha_demanda` date DEFAULT NULL,
  `monto_solicitado` decimal(10,2) DEFAULT NULL,
  `forma_pago` enum('Depósito bancario','Efectivo','Otro') DEFAULT NULL,
  `forma_pago_otro` varchar(255) DEFAULT NULL,
  `adj_certificado_nacimiento` tinyint(1) NOT NULL DEFAULT 0,
  `adj_prueba_ingresos` tinyint(1) NOT NULL DEFAULT 0,
  `adj_conversaciones` tinyint(1) NOT NULL DEFAULT 0,
  `adj_fotografias` tinyint(1) NOT NULL DEFAULT 0,
  `adj_cartas` tinyint(1) NOT NULL DEFAULT 0,
  `adj_otros` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_prenatal`
--

CREATE TABLE `asistencia_prenatal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asistencia_id` bigint(20) UNSIGNED NOT NULL,
  `exp_demandante` varchar(255) DEFAULT NULL,
  `nacionalidad_demandante` varchar(255) DEFAULT NULL,
  `ingresos_demandante` decimal(12,2) DEFAULT NULL,
  `zona_demandante` varchar(255) DEFAULT NULL,
  `ciudad_demandante` varchar(255) DEFAULT NULL,
  `exp_demandado` varchar(255) DEFAULT NULL,
  `lugar_trabajo_demandado` varchar(255) DEFAULT NULL,
  `fecha_inicio_relacion` date DEFAULT NULL,
  `fecha_fin_relacion` date DEFAULT NULL,
  `hubo_convivencia` tinyint(1) DEFAULT NULL,
  `edad_gestacional` int(11) DEFAULT NULL,
  `fecha_probable_parto` date DEFAULT NULL,
  `lugar_controles_medicos` varchar(255) DEFAULT NULL,
  `nombre_medico` varchar(255) DEFAULT NULL,
  `demandado_sabe_embarazo` tinyint(1) DEFAULT NULL,
  `demandado_ayuda_economica` tinyint(1) DEFAULT NULL,
  `certificado_medico` tinyint(1) NOT NULL DEFAULT 0,
  `fotocopia_ci_madre` tinyint(1) NOT NULL DEFAULT 0,
  `fotografias_relacion` tinyint(1) NOT NULL DEFAULT 0,
  `capturas_mensajes` tinyint(1) NOT NULL DEFAULT 0,
  `cartas_audios` tinyint(1) NOT NULL DEFAULT 0,
  `testigo1_nombre` varchar(255) DEFAULT NULL,
  `testigo1_ci` varchar(255) DEFAULT NULL,
  `testigo1_domicilio` varchar(255) DEFAULT NULL,
  `testigo1_testimonio` text DEFAULT NULL,
  `testigo2_nombre` varchar(255) DEFAULT NULL,
  `testigo2_ci` varchar(255) DEFAULT NULL,
  `testigo2_domicilio` varchar(255) DEFAULT NULL,
  `testigo2_testimonio` text DEFAULT NULL,
  `petitorio_asistencia` tinyint(1) NOT NULL DEFAULT 0,
  `monto_asistencia` decimal(12,2) DEFAULT NULL,
  `petitorio_medida` tinyint(1) NOT NULL DEFAULT 0,
  `petitorio_audiencia` tinyint(1) NOT NULL DEFAULT 0,
  `petitorio_adn` tinyint(1) NOT NULL DEFAULT 0,
  `domicilio_procesal` varchar(255) DEFAULT NULL,
  `numero_juzgado` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audiencias`
--

CREATE TABLE `audiencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `proceso` varchar(255) DEFAULT NULL,
  `demandante` varchar(255) DEFAULT NULL,
  `demandado` varchar(255) DEFAULT NULL,
  `abogado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo_proceso` varchar(255) DEFAULT NULL,
  `tipo_audiencia` enum('preliminar','conciliacion','pruebas','sentencia','otros') DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `juzgado` varchar(255) DEFAULT NULL,
  `juez` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoridades`
--

CREATE TABLE `autoridades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `unidad` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autos_admision`
--

CREATE TABLE `autos_admision` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `divorcio_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_emision` date NOT NULL,
  `numero_auto` varchar(255) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `estado` enum('ADMITIDO','EN OBSERVACION','RECHAZADO') NOT NULL DEFAULT 'ADMITIDO',
  `recepcion_confirmada` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carpetas`
--

CREATE TABLE `carpetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `padre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proceso_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proceso_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carpetas`
--

INSERT INTO `carpetas` (`id`, `nombre`, `padre_id`, `usuario_id`, `proceso_id`, `proceso_type`, `created_at`, `updated_at`) VALUES
(1, 'familiar', NULL, 1, NULL, NULL, '2025-09-12 03:55:19', '2025-09-12 03:55:19'),
(2, 'CIVIL', NULL, 1, NULL, NULL, '2025-09-12 03:55:31', '2025-09-12 03:55:31'),
(3, 'demndas divorcio', 1, 2, NULL, NULL, '2025-09-12 06:13:12', '2025-09-12 06:13:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casos_penales`
--

CREATE TABLE `casos_penales` (
  `id_caso` bigint(20) UNSIGNED NOT NULL,
  `numero_caso` varchar(255) DEFAULT NULL,
  `tipo_delito` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `etapa_procesal` varchar(255) NOT NULL,
  `abogado_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caso_denunciados`
--

CREATE TABLE `caso_denunciados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caso_id` bigint(20) UNSIGNED NOT NULL,
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `notificacion` enum('si','no') DEFAULT NULL,
  `delito_denunciado` varchar(255) DEFAULT NULL,
  `relato` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caso_denunciantes`
--

CREATE TABLE `caso_denunciantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caso_id` bigint(20) UNSIGNED NOT NULL,
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `relato` text DEFAULT NULL,
  `evidencias` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caso_testigos`
--

CREATE TABLE `caso_testigos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caso_id` bigint(20) UNSIGNED NOT NULL,
  `testigo_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_participante` enum('denunciante','denunciado') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cesacion_asistencia`
--

CREATE TABLE `cesacion_asistencia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `abogado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `tipo_cita` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `lugar` varchar(255) NOT NULL,
  `estado` enum('pendiente','aceptada','rechazada') NOT NULL DEFAULT 'pendiente',
  `notificar` tinyint(1) NOT NULL DEFAULT 0,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_documentos`
--

CREATE TABLE `cita_documentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cita_id` bigint(20) UNSIGNED NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `civil`
--

CREATE TABLE `civil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `civil_cases`
--

CREATE TABLE `civil_cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_caso` enum('civil','comercial','laboral','familiar') NOT NULL,
  `subtipo_caso` varchar(50) DEFAULT NULL,
  `tipo_proceso` varchar(50) DEFAULT NULL,
  `nro_expediente` varchar(50) NOT NULL,
  `juzgado` varchar(100) NOT NULL,
  `estado_caso` enum('activo','cerrado','en proceso') NOT NULL DEFAULT 'activo',
  `subestado_caso` varchar(50) DEFAULT NULL,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `materia` varchar(100) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contestaciones`
--

CREATE TABLE `contestaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filiacion_id` bigint(20) UNSIGNED NOT NULL,
  `demandante_id` bigint(20) UNSIGNED DEFAULT NULL,
  `demandado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_presentacion` date NOT NULL,
  `texto_contestacion` text NOT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contestacion_guarda`
--

CREATE TABLE `contestacion_guarda` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `abogado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `numero_proceso` varchar(255) NOT NULL,
  `juzgado` varchar(255) NOT NULL,
  `demandante_nombre` varchar(255) NOT NULL,
  `demandante_ci` varchar(20) NOT NULL,
  `demandante_domicilio` varchar(255) NOT NULL,
  `demandado_nombre` varchar(255) NOT NULL,
  `demandado_ci` varchar(20) NOT NULL,
  `demandado_domicilio` varchar(255) NOT NULL,
  `fecha_notificacion` date NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Demanda recibida',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `respuesta_hechos` enum('Acepto','Niego','Parcial') NOT NULL,
  `version_argumentos` text DEFAULT NULL,
  `fundamentos_derecho` text DEFAULT NULL,
  `petitorio` text DEFAULT NULL,
  `pruebas` text DEFAULT NULL,
  `otrosi_1` text DEFAULT NULL,
  `otrosi_2` text DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `correo_procesal` varchar(255) DEFAULT NULL,
  `domicilio_procesal` varchar(255) DEFAULT NULL,
  `rpa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenios_reguladores`
--

CREATE TABLE `convenios_reguladores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `convenioable_type` varchar(255) NOT NULL,
  `convenioable_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_custodia` varchar(255) DEFAULT NULL,
  `regimen_visitas` text DEFAULT NULL,
  `monto_pension` decimal(10,2) DEFAULT NULL,
  `forma_pago` varchar(255) DEFAULT NULL,
  `gastos_extra` text DEFAULT NULL,
  `educacion` text DEFAULT NULL,
  `salud` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_firma` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinaciones`
--

CREATE TABLE `coordinaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_inmediato_id` bigint(20) UNSIGNED NOT NULL,
  `unidad_policial` varchar(255) NOT NULL,
  `acta_aprehension` varchar(255) NOT NULL,
  `autoridad_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_remision` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cumplimiento_guarda`
--

CREATE TABLE `cumplimiento_guarda` (
  `id_cumplimiento` bigint(20) UNSIGNED NOT NULL,
  `guarda_custodia_id` bigint(20) UNSIGNED NOT NULL,
  `cumple_sentencia` enum('Sí','No') DEFAULT NULL,
  `fecha_revision` date DEFAULT NULL,
  `proceso_incumplimiento` tinyint(1) NOT NULL DEFAULT 0,
  `documento_seguimiento` varchar(255) DEFAULT NULL,
  `informe_social` text DEFAULT NULL,
  `reclamos` text DEFAULT NULL,
  `estado_caso` enum('Cumplido','En ejecución') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demandas`
--

CREATE TABLE `demandas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_demandado` varchar(255) NOT NULL,
  `ci_demandado` varchar(255) NOT NULL,
  `domicilio_demandado` varchar(255) NOT NULL,
  `detalle_gastos` text DEFAULT NULL,
  `monto_solicitado` decimal(12,2) NOT NULL,
  `estado` enum('en_proceso','demanda_presentada') NOT NULL DEFAULT 'en_proceso',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demandas_adopcion`
--

CREATE TABLE `demandas_adopcion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adopcion_id` bigint(20) UNSIGNED NOT NULL,
  `plantilla_demanda` text DEFAULT NULL,
  `archivo_demanda` varchar(255) DEFAULT NULL,
  `juzgado` varchar(255) DEFAULT NULL,
  `fecha_presentacion` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demandas_guardas`
--

CREATE TABLE `demandas_guardas` (
  `id_demanda` bigint(20) UNSIGNED NOT NULL,
  `id_solicitante` bigint(20) UNSIGNED NOT NULL,
  `id_menor` bigint(20) UNSIGNED NOT NULL,
  `id_demandado` bigint(20) UNSIGNED NOT NULL,
  `fundamento_legal` text DEFAULT NULL,
  `regimen_visitas` text DEFAULT NULL,
  `tipo_custodia` enum('Total','Compartida') DEFAULT NULL,
  `estado` enum('Borrador','Presentada') NOT NULL DEFAULT 'Borrador',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demandas_incumplimiento`
--

CREATE TABLE `demandas_incumplimiento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `juez` varchar(255) DEFAULT NULL,
  `ciudad_jurisdiccion` varchar(255) DEFAULT NULL,
  `lugar_fecha` varchar(255) DEFAULT NULL,
  `demandante_nombre` varchar(255) NOT NULL,
  `demandante_ci` varchar(255) NOT NULL,
  `demandante_domicilio` varchar(255) NOT NULL,
  `demandante_telefono` varchar(255) DEFAULT NULL,
  `demandado_nombre` varchar(255) NOT NULL,
  `demandado_ci` varchar(255) NOT NULL,
  `demandado_domicilio` varchar(255) NOT NULL,
  `fecha_sentencia` date NOT NULL,
  `numero_expediente` varchar(255) NOT NULL,
  `nombre_menor` varchar(255) NOT NULL,
  `descripcion_incumplimiento` text NOT NULL,
  `fundamentos_derecho` text DEFAULT NULL,
  `petitorio` text DEFAULT NULL,
  `firmante_nombre` varchar(255) NOT NULL,
  `abogado_nombre` varchar(255) NOT NULL,
  `abogado_matricula` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disoluciones_union_libre`
--

CREATE TABLE `disoluciones_union_libre` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proceso_union_libre_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_ruptura` date DEFAULT NULL,
  `motivo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`motivo`)),
  `motivo_otro` varchar(255) DEFAULT NULL,
  `existen_bienes` enum('si','no') NOT NULL DEFAULT 'no',
  `detalle_bienes` text DEFAULT NULL,
  `tienen_hijos` enum('si','no') NOT NULL DEFAULT 'no',
  `custodia` enum('madre','padre','compartida') DEFAULT NULL,
  `visitas` text DEFAULT NULL,
  `asistencia_familiar` enum('si','no') NOT NULL DEFAULT 'no',
  `monto_asistencia` decimal(10,2) DEFAULT NULL,
  `modalidad_asistencia` enum('mensual','quincenal','otro') DEFAULT NULL,
  `testigo1_id` bigint(20) UNSIGNED DEFAULT NULL,
  `testigo2_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divorcios`
--

CREATE TABLE `divorcios` (
  `id_divorcio` bigint(20) UNSIGNED NOT NULL,
  `tipo_divorcio` enum('Contencioso','Mutuo Acuerdo') NOT NULL,
  `conyuge1_id` bigint(20) UNSIGNED NOT NULL,
  `conyuge2_id` bigint(20) UNSIGNED NOT NULL,
  `abogado_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_matrimonio` date DEFAULT NULL,
  `lugar_matrimonio` varchar(255) DEFAULT NULL,
  `oficialia` varchar(50) DEFAULT NULL,
  `libro` varchar(50) DEFAULT NULL,
  `partida` varchar(50) DEFAULT NULL,
  `folio` varchar(50) DEFAULT NULL,
  `regimen_patrimonial` enum('Sociedad Conyugal','Separación de Bienes') NOT NULL DEFAULT 'Sociedad Conyugal',
  `ciudad_procesal` varchar(255) DEFAULT NULL,
  `correo_procesal` varchar(255) DEFAULT NULL,
  `domicilio_procesal` varchar(255) DEFAULT NULL,
  `rpa` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guarda_custodia` varchar(255) DEFAULT NULL,
  `regimen_visitas` varchar(255) DEFAULT NULL,
  `asistencia_familiar` varchar(255) DEFAULT NULL,
  `division_bienes` varchar(255) DEFAULT NULL,
  `documentos_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documentos_json`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divorcio_contenciosos`
--

CREATE TABLE `divorcio_contenciosos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `divorcio_id` bigint(20) UNSIGNED NOT NULL,
  `motivo` enum('Abandono','Infidelidad','Violencia','Incompatibilidad','Otro') NOT NULL,
  `detalle_motivo` text DEFAULT NULL,
  `pruebas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pruebas`)),
  `archivos_adjuntos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`archivos_adjuntos`)),
  `hijos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hijos`)),
  `bienes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bienes`)),
  `estado_documento` enum('borrador','enviado','firmado') NOT NULL DEFAULT 'borrador',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id_documento` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_subida` datetime NOT NULL,
  `texto_extraido` longtext DEFAULT NULL,
  `proceso_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proceso_type` varchar(255) DEFAULT NULL,
  `carpeta_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id_documento`, `nombre`, `tipo`, `archivo`, `descripcion`, `fecha_subida`, `texto_extraido`, `proceso_id`, `proceso_type`, `carpeta_id`, `created_at`, `updated_at`) VALUES
(2, 'gimena quispe mamni', 'pdf', 'documentos/sin_carpeta/qLzO0ytE7nDtHk8StPh4jqpMt4slGKUfuc5gagVa.pdf', 'este documnto', '2025-09-11 23:55:52', NULL, NULL, NULL, NULL, '2025-09-12 03:55:52', '2025-09-12 03:55:52'),
(3, 'gimena quispe mamni', 'pdf', 'documentos/sin_carpeta/y7wTIOZvWKe8JVobFVS9cpRWCWOi1YEcBsv2Ecj9.pdf', 'este documnto', '2025-09-11 23:58:57', NULL, NULL, NULL, NULL, '2025-09-12 03:58:57', '2025-09-12 03:58:57'),
(4, 'gimena quispe mamni', 'pdf', 'documentos/sin_carpeta/PzqhgMS9GAgY5497RnmEwiByNozikLHt4jfdDNVa.pdf', 'esta e sdshbfhdbr', '2025-09-12 00:09:22', NULL, NULL, NULL, NULL, '2025-09-12 04:09:22', '2025-09-12 04:09:22'),
(5, 'memorial', 'pdf', 'documentos/sin_carpeta/kxunjMQgnR8QlBXAZEPUeFLz78s6aIs10DbFBvBq.pdf', 'pertenece a id eld chamba', '2025-09-12 00:16:37', NULL, NULL, NULL, NULL, '2025-09-12 04:16:37', '2025-09-12 04:16:37'),
(6, 'richari', 'pdf', 'documentos/1/GVLRDMc8hUap63Uj3KudSQeRaMJf96nafr8j8sZj.pdf', 'esta', '2025-09-12 00:21:48', NULL, NULL, NULL, 1, '2025-09-12 04:21:48', '2025-09-12 04:21:48'),
(7, 'memorial', 'docx', 'documentos/3/1BLsl8IoVVGq6yqZ0eGvF94IjnsgkC8r14fvZXwe.docx', 'esta', '2025-09-12 02:44:34', NULL, NULL, NULL, 3, '2025-09-12 06:44:34', '2025-09-12 06:44:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecuciones`
--

CREATE TABLE `ejecuciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_abreviado_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_sentencia` varchar(255) NOT NULL,
  `carcel` varchar(255) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `tiempo_condena` varchar(255) DEFAULT NULL,
  `monto_multa` decimal(10,2) DEFAULT NULL,
  `plazo_pago` date DEFAULT NULL,
  `estado_pago` enum('pendiente','pagado','mora') DEFAULT NULL,
  `lugar_trabajo` varchar(255) DEFAULT NULL,
  `horas_impuestas` int(11) DEFAULT NULL,
  `horas_cumplidas` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecuciones_sentencia`
--

CREATE TABLE `ejecuciones_sentencia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_sustancia_id` bigint(20) UNSIGNED NOT NULL,
  `sentencia` enum('Condenatoria','Absolutoria') DEFAULT NULL,
  `duracion_pena` int(11) DEFAULT NULL,
  `regimen_penitenciario` varchar(255) DEFAULT NULL,
  `beneficios` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`beneficios`)),
  `observaciones` text DEFAULT NULL,
  `acta_destruccion` varchar(255) DEFAULT NULL,
  `bienes_dircabi` text DEFAULT NULL,
  `fecha_cierre` date DEFAULT NULL,
  `documentos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documentos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estrategia_defensa`
--

CREATE TABLE `estrategia_defensa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_sustancia_id` bigint(20) UNSIGNED DEFAULT NULL,
  `revision_documental` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`revision_documental`)),
  `otros_documentos` varchar(255) DEFAULT NULL,
  `adjuntos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`adjuntos`)),
  `irregularidades` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`irregularidades`)),
  `detalle_irregularidades` text DEFAULT NULL,
  `linea_defensa` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`linea_defensa`)),
  `detalle_defensa` text DEFAULT NULL,
  `plan_accion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`plan_accion`)),
  `detalle_plan` text DEFAULT NULL,
  `observaciones_abogado` text DEFAULT NULL,
  `estrategia_definida` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapas_intermedias`
--

CREATE TABLE `etapas_intermedias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_sustancia_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_audiencia` date DEFAULT NULL,
  `resolucion` text DEFAULT NULL,
  `salida_alternativa` enum('procedimiento_abreviado','conciliacion','ninguna') DEFAULT NULL,
  `procedimiento_abreviado` enum('si','no') DEFAULT NULL,
  `conciliacion` enum('si','no') DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `archivos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`archivos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapas_investigativas`
--

CREATE TABLE `etapas_investigativas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_sustancia_id` bigint(20) UNSIGNED NOT NULL,
  `actuaciones_felcn` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`actuaciones_felcn`)),
  `investigacion_fiscal` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`investigacion_fiscal`)),
  `pericias` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pericias`)),
  `testigos_entrevistas` text DEFAULT NULL,
  `documentos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documentos`)),
  `n_caso_felcn` varchar(255) DEFAULT NULL,
  `n_acta_secuestro` varchar(255) DEFAULT NULL,
  `tipo_prueba_incautada` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones_adopciones`
--

CREATE TABLE `evaluaciones_adopciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adopcion_id` bigint(20) UNSIGNED NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'En evaluación',
  `req_mayor_25` tinyint(1) NOT NULL DEFAULT 0,
  `req_diferencia_edad` tinyint(1) NOT NULL DEFAULT 0,
  `req_antecedentes` tinyint(1) NOT NULL DEFAULT 0,
  `req_medico` tinyint(1) NOT NULL DEFAULT 0,
  `req_solvencia` tinyint(1) NOT NULL DEFAULT 0,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones_juridicas`
--

CREATE TABLE `evaluaciones_juridicas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asistencia_id` bigint(20) UNSIGNED NOT NULL,
  `resumen_caso` text DEFAULT NULL,
  `anotaciones_abogado` text DEFAULT NULL,
  `decision` enum('proceder_demanda','archivar','esperar_documentos') NOT NULL DEFAULT 'proceder_demanda',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones_legales`
--

CREATE TABLE `evaluaciones_legales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guarda_custodia_id` bigint(20) UNSIGNED NOT NULL,
  `solicitante` varchar(255) NOT NULL,
  `menor` varchar(255) NOT NULL,
  `conflicto` varchar(255) DEFAULT NULL,
  `documentos_recibidos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documentos_recibidos`)),
  `observaciones` text DEFAULT NULL,
  `nivel_urgencia` enum('Alta','Media','Baja') NOT NULL DEFAULT 'Media',
  `recomienda_demanda` tinyint(1) DEFAULT NULL,
  `emitir_medida_provisional` tinyint(1) NOT NULL DEFAULT 0,
  `redactar_demanda` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencias`
--

CREATE TABLE `evidencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_inmediato_id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `cadena_custodia` varchar(255) NOT NULL,
  `ubicacion_objeto` varchar(255) DEFAULT NULL,
  `duracion_video` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familiares`
--

CREATE TABLE `familiares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filiaciones`
--

CREATE TABLE `filiaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_proceso` varchar(255) NOT NULL,
  `nombre_menor` varchar(255) NOT NULL,
  `fecha_nac_menor` date NOT NULL,
  `nombre_progenitor` varchar(255) NOT NULL,
  `ci_progenitor` varchar(255) DEFAULT NULL,
  `domicilio_progenitor` varchar(255) DEFAULT NULL,
  `pruebas_aportadas` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `id_abogado` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filiacion_judicial`
--

CREATE TABLE `filiacion_judicial` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_demandante` bigint(20) UNSIGNED NOT NULL,
  `id_menor` bigint(20) UNSIGNED NOT NULL,
  `id_demandado` bigint(20) UNSIGNED DEFAULT NULL,
  `id_abogado` bigint(20) UNSIGNED NOT NULL,
  `hechos` text DEFAULT NULL,
  `fundamentos_derecho` text DEFAULT NULL,
  `pruebas` text DEFAULT NULL,
  `petitorio` text DEFAULT NULL,
  `otrosi_digo` text DEFAULT NULL,
  `fecha_presentacion` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guarda_custodias`
--

CREATE TABLE `guarda_custodias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `solicitante_id` bigint(20) UNSIGNED NOT NULL,
  `menor_id` bigint(20) UNSIGNED NOT NULL,
  `progenitor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `abogado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `situacion_actual` varchar(255) DEFAULT NULL,
  `petitorio` text DEFAULT NULL,
  `fundamento_legal` text DEFAULT NULL,
  `pruebas` text DEFAULT NULL,
  `regimen_visitas` text DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Recepción',
  `correo_procesal` varchar(255) DEFAULT NULL,
  `domicilio_procesal` varchar(255) DEFAULT NULL,
  `rpa` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `admite_demanda` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_notificacion` date DEFAULT NULL,
  `guarda_provisional` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hijos`
--

CREATE TABLE `hijos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proceso_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proceso_type` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `partida_nac` varchar(255) DEFAULT NULL,
  `ci` varchar(20) DEFAULT NULL,
  `lugar_nacimiento` varchar(255) DEFAULT NULL,
  `custodia` varchar(255) DEFAULT NULL,
  `discapacidad` tinyint(1) NOT NULL DEFAULT 0,
  `descripcion_necesidades` text DEFAULT NULL,
  `nivel_escolaridad` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impugnaciones_filiacion`
--

CREATE TABLE `impugnaciones_filiacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `demandante_id` bigint(20) UNSIGNED NOT NULL,
  `demandado_id` bigint(20) UNSIGNED NOT NULL,
  `menor_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_demanda` date NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `hechos` text NOT NULL,
  `fundamentos` text NOT NULL,
  `petitorio` text NOT NULL,
  `otrosi` text DEFAULT NULL,
  `anexos` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imputaciones_medidas`
--

CREATE TABLE `imputaciones_medidas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_sustancia_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_imputacion` date NOT NULL,
  `delito_imputado` varchar(255) NOT NULL,
  `medida_resuelta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medida_resuelta`)),
  `documentos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documentos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imputados`
--

CREATE TABLE `imputados` (
  `id_imputado` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ci_lugar` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `esta_detenido` tinyint(1) NOT NULL,
  `nacionalidad` varchar(255) NOT NULL,
  `nombre_abogado` varchar(255) NOT NULL,
  `telefono_abogado` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `calle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes`
--

CREATE TABLE `informes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hijo_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_informe` enum('psicologico','social','ambos') NOT NULL,
  `profesional_nombre` varchar(255) NOT NULL,
  `profesional_ci` varchar(25) DEFAULT NULL,
  `profesional_institucion` varchar(255) DEFAULT NULL,
  `fecha_informe` date DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `resumen` text DEFAULT NULL,
  `archivo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `investigaciones_incidentes`
--

CREATE TABLE `investigaciones_incidentes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_sustancia_id` bigint(20) UNSIGNED NOT NULL,
  `pericias` text DEFAULT NULL,
  `testigos` text DEFAULT NULL,
  `imputado` text DEFAULT NULL,
  `informes` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `tipo_incidente` varchar(255) DEFAULT NULL,
  `resumen_incidente` text DEFAULT NULL,
  `fundamento` text DEFAULT NULL,
  `archivos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`archivos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `investigacion_penal`
--

CREATE TABLE `investigacion_penal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_penal_abreviado` bigint(20) UNSIGNED NOT NULL,
  `id_autoridad` bigint(20) UNSIGNED NOT NULL,
  `fecha_declaracion` date DEFAULT NULL,
  `medio_declaracion` enum('Presencial','Virtual','Escrita') DEFAULT NULL,
  `observaciones_declaracion` text DEFAULT NULL,
  `numero_expediente` varchar(255) NOT NULL,
  `tipo_medida_cautelar` enum('Detención preventiva','Presentación periódica','Prohibición de acercarse','Otra') DEFAULT NULL,
  `otra_medida_cautelar` varchar(255) DEFAULT NULL,
  `fecha_imposicion_medida` date DEFAULT NULL,
  `duracion_condiciones` varchar(255) DEFAULT NULL,
  `solicito_medida_sustitutiva` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_medida_sustitutiva` varchar(255) DEFAULT NULL,
  `fecha_solicitud_sustitutiva` date DEFAULT NULL,
  `estado_solicitud_sustitutiva` enum('Aprobada','Rechazada','En trámite') DEFAULT NULL,
  `observaciones_generales` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juicio_orals`
--

CREATE TABLE `juicio_orals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_sustancia_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_audiencia` date DEFAULT NULL,
  `testigos` text DEFAULT NULL,
  `resultado` enum('condenatoria','absolutoria') DEFAULT NULL,
  `alegatos_iniciales` text DEFAULT NULL,
  `produccion_prueba` text DEFAULT NULL,
  `alegatos_clausura` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `archivos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`archivos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_19_021134_create_usuarios_table', 1),
(5, '2025_03_25_212953_update_rol_enum_in_usuarios_table', 1),
(6, '2025_04_04_015447_create_pruebas_table', 1),
(7, '2025_04_16_013845_create_tarifas_table', 1),
(8, '2025_04_16_204541_create_sentencias_table', 1),
(9, '2025_04_17_144250_create_notificaciones_table', 1),
(10, '2025_04_17_163653_create_imputados_table', 1),
(11, '2025_04_17_170027_create_victimas_table', 1),
(12, '2025_04_23_174603_create_plazos_judiciales_table', 1),
(13, '2025_04_24_210918_create_penales_table', 1),
(14, '2025_04_29_163459_create_civil_cases_table', 1),
(15, '2025_05_03_190057_create_agendas_table', 1),
(16, '2025_05_08_015705_create_citas_table', 1),
(17, '2025_06_23_205709_create_cita_documentos_table', 1),
(18, '2025_06_25_173245_create_personas_table', 1),
(19, '2025_06_25_185424_create_hijos_table', 1),
(20, '2025_06_30_225405_create_informes_table', 1),
(21, '2025_07_01_005543_create_convenios_reguladores_table', 1),
(22, '2025_07_02_193947_create_violencias_table', 1),
(23, '2025_07_04_162452_create_familiares_table', 1),
(24, '2025_07_04_162454_create_asistencias_table', 1),
(25, '2025_07_09_023951_create_pagos_asistencias_table', 1),
(26, '2025_07_10_162453_create_divorcios_table', 1),
(27, '2025_07_13_020917_create_evaluaciones_juridicas_table', 1),
(28, '2025_07_13_025311_create_demandas_table', 1),
(29, '2025_07_13_164440_create_anotaciones_table', 1),
(30, '2025_07_15_004643_create_guarda_custodias_table', 1),
(31, '2025_07_15_022915_create_demandas_guardas_table', 1),
(32, '2025_07_15_184243_create_evaluaciones_legales_table', 1),
(33, '2025_07_16_031550_create_notificacion_guardas_table', 1),
(34, '2025_07_16_195707_create_cumplimiento_guarda_table', 1),
(35, '2025_07_16_204018_create_demandas_incumplimiento_table', 1),
(36, '2025_07_17_145205_create_filiaciones_table', 1),
(37, '2025_07_17_172204_create_reconocimiento_voluntarios_table', 1),
(38, '2025_07_18_003216_create_participantes_proceso_penal_table', 1),
(39, '2025_07_18_011253_create_presentaciones_penales_table', 1),
(40, '2025_07_18_024541_create_actuaciones_table', 1),
(41, '2025_07_18_205848_create_filiacion_judicial_table', 1),
(42, '2025_07_18_235905_create_impugnaciones_filiacion_table', 1),
(43, '2025_07_19_014704_create_notificaciones_judiciales_table', 1),
(44, '2025_07_19_025434_create_contestaciones_table', 1),
(45, '2025_07_19_034721_create_adopciones_table', 1),
(46, '2025_07_19_190941_create_evaluaciones_adopciones_table', 1),
(47, '2025_07_19_200857_create_demandas_adopcion_table', 1),
(48, '2025_07_20_172413_add_campos_demanda_to_divorcios_table', 1),
(49, '2025_07_21_193057_create_divorcio_contenciosos_table', 1),
(50, '2025_07_22_041921_create_presentaciones_divorcio_table', 1),
(51, '2025_07_24_034057_create_procesos_union_libre_table', 1),
(52, '2025_07_25_201255_create_sentencia_union_libres_table', 1),
(53, '2025_07_27_185313_add_texto_demanda_disolucion_to_procesos_union_libre_table', 1),
(54, '2025_07_28_173636_create_testigos_table', 1),
(55, '2025_07_28_173637_create_disoluciones_union_libre_table', 1),
(56, '2025_07_29_185805_create_reconocimientos_union_libre_tables', 1),
(57, '2025_07_30_011859_create_seguimiento_judicial_table', 1),
(58, '2025_07_31_020205_add_documentos_json_to_divorcios_table', 1),
(59, '2025_07_31_170210_create_presentaciones_juzgado_table', 1),
(60, '2025_07_31_195608_create_autos_admision_table', 1),
(61, '2025_08_01_174548_create_notificacion_divorcio_table', 1),
(62, '2025_08_03_190838_create_asistencia_familiar_table', 1),
(63, '2025_08_06_005538_create_asistencia_prenatal_table', 1),
(64, '2025_08_06_021344_create_asistencia_ordinaria_table', 1),
(65, '2025_08_06_202610_create_asistencia_conyuge_table', 1),
(66, '2025_08_06_212404_create_asistencia_adulto_table', 1),
(67, '2025_08_10_193519_create_apelacions_table', 1),
(68, '2025_08_11_212444_create_seguimiento_guarda_table', 1),
(69, '2025_08_12_014521_create_contestacion_guarda_table', 1),
(70, '2025_08_13_040007_add_campos_to_contestacion_guarda_table', 1),
(71, '2025_08_13_040939_create_resoluciones_guardas_table', 1),
(72, '2025_08_21_174614_create_resolucion_adopcion_table', 1),
(73, '2025_08_22_114446_create_casos_penales_table', 1),
(74, '2025_08_22_203721_create_civil_table', 1),
(75, '2025_08_23_201344_create_penal_ordinario_table', 1),
(76, '2025_08_23_225436_create_robo_table', 1),
(77, '2025_08_24_033300_create_penal_abreviado_table', 1),
(78, '2025_08_24_040212_create_penal_sustancias_table', 1),
(79, '2025_08_24_194958_create_penal_entrevista_table', 1),
(80, '2025_08_25_174313_create_estrategia_defensa_table', 1),
(81, '2025_08_25_185950_create_etapa_investigativa_table', 1),
(82, '2025_08_25_202554_create_imputaciones_medidas_table', 1),
(83, '2025_08_26_000241_create_investigaciones_incidentes_table', 1),
(84, '2025_08_26_012040_create_etapas_intermedias_table', 1),
(85, '2025_08_26_014327_create_juicio_orals_table', 1),
(86, '2025_08_26_031451_create_ejecuciones_sentencia_table', 1),
(87, '2025_08_26_160857_create_audiencias_table', 1),
(88, '2025_08_26_203127_create_penal_inmediato_table', 1),
(89, '2025_08_27_220027_create_procedimiento_inmediatos_table', 1),
(90, '2025_08_27_232700_create_evidencias_table', 1),
(91, '2025_08_28_013424_create_solicitudes_procedimiento_table', 1),
(92, '2025_08_28_190743_create_autoridades_table', 1),
(93, '2025_08_28_192536_create_coordinaciones_table', 1),
(94, '2025_08_28_234727_create_asignaciones_institucionales_table', 1),
(95, '2025_08_29_030922_create_acusaciones_rapidas_table', 1),
(96, '2025_08_29_040258_create_sentencias_inmediatas_table', 1),
(97, '2025_08_29_042317_create_apelaciones_table', 1),
(98, '2025_08_29_181132_create_pagos_table', 1),
(99, '2025_09_02_171626_create_investigacion_penal_table', 1),
(100, '2025_09_02_190627_create_negociacion_fiscal_table', 1),
(101, '2025_09_02_231804_create_ejecuciones_table', 1),
(102, '2025_09_03_165014_create_provisional_table', 1),
(103, '2025_09_03_182033_create_prueba_asistencia_table', 1),
(104, '2025_09_04_031314_create_cesacion_asistencia_table', 1),
(105, '2025_09_10_185004_create_events_table', 1),
(106, '2025_09_11_223923_create_carpetas_table', 1),
(107, '2025_09_11_223924_create_documentos_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negociacion_fiscal`
--

CREATE TABLE `negociacion_fiscal` (
  `id_negociacion_fiscal` bigint(20) UNSIGNED NOT NULL,
  `id_penal_abreviado` bigint(20) UNSIGNED NOT NULL,
  `nombre_imputado` varchar(255) DEFAULT NULL,
  `ci_imputado` varchar(20) DEFAULT NULL,
  `tipo_delito` text DEFAULT NULL,
  `acepta_culpabilidad` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_pena` varchar(255) DEFAULT NULL,
  `pena_reducida` varchar(255) DEFAULT NULL,
  `victima_notificada` tinyint(1) NOT NULL DEFAULT 0,
  `observaciones_victima` text DEFAULT NULL,
  `fecha_acuerdo` date DEFAULT NULL,
  `observaciones_generales` text DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `fecha_evento` datetime DEFAULT NULL,
  `estado` enum('pendiente','enviado') NOT NULL DEFAULT 'pendiente',
  `canal` enum('sistema','email','whatsapp') NOT NULL DEFAULT 'sistema',
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `url_direccion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones_judiciales`
--

CREATE TABLE `notificaciones_judiciales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `filiacion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_notificacion` date NOT NULL,
  `tipo` enum('citacion','sentencia','resolucion','auto_judicial','otros') NOT NULL,
  `estado` enum('entregado','pendiente','rechazado') NOT NULL,
  `canal` enum('email','sms','sistema','personal') NOT NULL DEFAULT 'sistema',
  `url_direccion` varchar(255) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_divorcio`
--

CREATE TABLE `notificacion_divorcio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `divorcio_id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `demandado` varchar(255) DEFAULT NULL,
  `fecha_notificacion` date DEFAULT NULL,
  `modalidad_cedula` tinyint(1) NOT NULL DEFAULT 0,
  `modalidad_edictos` tinyint(1) NOT NULL DEFAULT 0,
  `estado` enum('notificado','edictos') DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_guardas`
--

CREATE TABLE `notificacion_guardas` (
  `id_notificacion` bigint(20) UNSIGNED NOT NULL,
  `fecha_notificacion` date NOT NULL,
  `medio` enum('judicial','personal','cedulon') NOT NULL,
  `archivo_respuesta` varchar(255) DEFAULT NULL,
  `respuesta` enum('acepta_custodia','acepta_visitas','se_opone') DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `notificado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `tarifa_id` bigint(20) UNSIGNED NOT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL DEFAULT 0.00,
  `monto_pendiente` decimal(10,2) GENERATED ALWAYS AS (`monto_total` - `monto_pagado`) VIRTUAL,
  `fecha_pago` date DEFAULT NULL,
  `estado` enum('Pendiente','Pagado') NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_asistencias`
--

CREATE TABLE `pagos_asistencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asistencia_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL,
  `comprobante` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes_proceso_penal`
--

CREATE TABLE `participantes_proceso_penal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id_usuarios` bigint(20) UNSIGNED NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `rol_en_proceso` enum('Víctima','Imputado','Testigo') NOT NULL,
  `tipo_delito_presunto` varchar(255) NOT NULL,
  `fecha_hecho` date NOT NULL,
  `narracion_hecho` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `penales`
--

CREATE TABLE `penales` (
  `id_penal` bigint(20) UNSIGNED NOT NULL,
  `fecha_apertura` date NOT NULL,
  `fecha_hecho` date NOT NULL,
  `fecha_cierre` date DEFAULT NULL,
  `lugar_hecho` varchar(255) NOT NULL,
  `expediente` varchar(255) NOT NULL,
  `nurej` varchar(255) NOT NULL,
  `depart_judicial` varchar(255) NOT NULL,
  `juzgado_instancia` varchar(255) NOT NULL,
  `numero_fiscalia` varchar(255) NOT NULL,
  `estado_caso` varchar(255) NOT NULL,
  `fiscal_asignado` varchar(255) NOT NULL,
  `juez` varchar(255) NOT NULL,
  `descripcion_hecho` text NOT NULL,
  `tipo_delito` varchar(255) NOT NULL,
  `delito_especifico` varchar(255) DEFAULT NULL,
  `medidas_cautelares` varchar(255) DEFAULT NULL,
  `etapa_proceso` varchar(255) NOT NULL,
  `fase_procesal` varchar(255) NOT NULL,
  `recursos` varchar(255) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `penal_abreviado`
--

CREATE TABLE `penal_abreviado` (
  `id_penal_abreviado` bigint(20) UNSIGNED NOT NULL,
  `delito_imputado` varchar(255) NOT NULL,
  `fiscalia` varchar(255) NOT NULL,
  `numero_caso` varchar(255) NOT NULL,
  `etapa_procesal` enum('Preparatoria','Juicio Oral') NOT NULL,
  `acepta_culpabilidad` tinyint(1) NOT NULL,
  `fiscal_de_acuerdo` tinyint(1) NOT NULL,
  `victima_de_acuerdo` tinyint(1) NOT NULL,
  `fecha_solicitud_abreviada` date DEFAULT NULL,
  `fecha_audiencia` date DEFAULT NULL,
  `con_detencion_preventiva` tinyint(1) NOT NULL DEFAULT 0,
  `observaciones` text DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'registrado',
  `antecedentes_policiales` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Revisión de antecedentes policiales',
  `detalle_antecedentes_policiales` text DEFAULT NULL COMMENT 'Detalle de la revisión de antecedentes policiales',
  `antecedentes_fiscales` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Revisión de antecedentes fiscales',
  `detalle_antecedentes_fiscales` text DEFAULT NULL COMMENT 'Detalle de la revisión de antecedentes fiscales',
  `antecedentes_judiciales` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Revisión de antecedentes judiciales',
  `detalle_antecedentes_judiciales` text DEFAULT NULL COMMENT 'Detalle de la revisión de antecedentes judiciales',
  `id_abogado` bigint(20) UNSIGNED NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `penal_denunciados`
--

CREATE TABLE `penal_denunciados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_id` bigint(20) UNSIGNED NOT NULL,
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `penal_denunciantes`
--

CREATE TABLE `penal_denunciantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_id` bigint(20) UNSIGNED NOT NULL,
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `penal_entrevista`
--

CREATE TABLE `penal_entrevista` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_sustancia_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_entrevista` date NOT NULL,
  `relato_hechos` text NOT NULL,
  `documentos_revisados` varchar(255) DEFAULT NULL,
  `situacion_actual` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `penal_inmediato`
--

CREATE TABLE `penal_inmediato` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_imputado` bigint(20) UNSIGNED NOT NULL,
  `id_abogado` bigint(20) UNSIGNED DEFAULT NULL,
  `hora_llegada` time DEFAULT NULL,
  `aprehendido` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_aprehension` datetime DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `correo_procesal` varchar(255) DEFAULT NULL,
  `domicilio_procesal` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `penal_ordinario`
--

CREATE TABLE `penal_ordinario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_proceso` varchar(255) NOT NULL DEFAULT 'Penal Ordinario',
  `tipo_delito` varchar(255) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `etapa_procesal` enum('Investigación Preliminar','Imputación','Audiencia Cautelar','Juicio Oral','Sentencia') DEFAULT NULL,
  `rol_proceso` enum('denunciante','denunciado') DEFAULT NULL,
  `id_abogado` bigint(20) UNSIGNED NOT NULL,
  `numero_caso` varchar(255) DEFAULT NULL,
  `fecha_notificacion` date DEFAULT NULL,
  `medidas_cautelares` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medidas_cautelares`)),
  `evidencias` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `penal_sustancias`
--

CREATE TABLE `penal_sustancias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ci` varchar(255) NOT NULL,
  `domicilio` varchar(255) NOT NULL,
  `edad` int(11) NOT NULL,
  `tipo_proceso` enum('Producción de coca excedentaria','Tráfico de sustancias controladas','Transporte de drogas','Fabricación ilícita','Suministro y consumo en circunstancias específicas','Asociación delictuosa para narcotráfico') NOT NULL,
  `articulo_aplicable` varchar(255) NOT NULL,
  `juzgado` varchar(255) NOT NULL,
  `autoridad` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`autoridad`)),
  `fecha_aprehension` date DEFAULT NULL,
  `cantidad_coca` decimal(10,2) DEFAULT NULL,
  `zona_produccion` varchar(255) DEFAULT NULL,
  `lugar_incautacion` varchar(255) DEFAULT NULL,
  `destino_sustancia` varchar(255) DEFAULT NULL,
  `medio_transporte` varchar(255) DEFAULT NULL,
  `otro_transporte` varchar(255) DEFAULT NULL,
  `lugar_intercepcion` varchar(255) DEFAULT NULL,
  `destino_transporte` varchar(255) DEFAULT NULL,
  `tipo_sustancia_fabricada` varchar(255) DEFAULT NULL,
  `lugar_fabricacion` varchar(255) DEFAULT NULL,
  `equipos_lab` varchar(255) DEFAULT NULL,
  `detalles_lab` varchar(255) DEFAULT NULL,
  `lugar_incidencia` varchar(255) DEFAULT NULL,
  `circunstancia` varchar(255) DEFAULT NULL,
  `otra_circunstancia` varchar(255) DEFAULT NULL,
  `tipo_asociacion` varchar(255) DEFAULT NULL,
  `sustancias_involucradas` varchar(255) DEFAULT NULL,
  `lugar_operacion` varchar(255) DEFAULT NULL,
  `id_abogado` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `ci` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `profesion` varchar(255) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `estado_civil` varchar(255) DEFAULT NULL,
  `parentesco` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `nacionalidad` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plazos_judiciales`
--

CREATE TABLE `plazos_judiciales` (
  `id_plazo` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `id_procesos` bigint(20) UNSIGNED NOT NULL,
  `fecha_limite` datetime NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `notificar` tinyint(1) NOT NULL DEFAULT 0,
  `estado_plazo` varchar(255) NOT NULL,
  `horas_alerta` int(11) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones_divorcio`
--

CREATE TABLE `presentaciones_divorcio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `divorcio_id` bigint(20) UNSIGNED NOT NULL,
  `tribunal` varchar(255) NOT NULL,
  `numero_proceso` varchar(255) NOT NULL,
  `fecha_presentacion` date NOT NULL,
  `acuse_pdf` varchar(255) DEFAULT NULL,
  `estado_proceso` enum('En revisión','Audiencia programada','En espera de sentencia') NOT NULL DEFAULT 'En revisión',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones_juzgado`
--

CREATE TABLE `presentaciones_juzgado` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `divorcio_id` bigint(20) UNSIGNED NOT NULL,
  `juzgado_asignado` varchar(255) NOT NULL,
  `fecha_presentacion` date NOT NULL,
  `hoja_ruta` varchar(255) NOT NULL,
  `estado_proceso` varchar(255) NOT NULL DEFAULT 'EN TRÁMITE',
  `documentos_presentados` text DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones_penales`
--

CREATE TABLE `presentaciones_penales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_presentacion` enum('Denuncia','Querella') NOT NULL,
  `fecha_presentacion` date DEFAULT NULL,
  `fiscal_asignado` varchar(255) DEFAULT NULL,
  `numero_caso` varchar(255) DEFAULT NULL,
  `narracion_hecho` text NOT NULL,
  `memorial` varchar(255) DEFAULT NULL,
  `pruebas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pruebas`)),
  `usuario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimiento_inmediatos`
--

CREATE TABLE `procedimiento_inmediatos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_inmediato_id` bigint(20) UNSIGNED NOT NULL,
  `autoridad` varchar(255) NOT NULL,
  `lugar_hecho` varchar(255) NOT NULL,
  `fecha_hecho` date NOT NULL,
  `relato` text NOT NULL,
  `testigos` varchar(255) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `requisitos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requisitos`)),
  `documentos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documentos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos_union_libre`
--

CREATE TABLE `procesos_union_libre` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `solicitante_nombre_completo` varchar(255) NOT NULL,
  `solicitante_ci` varchar(20) NOT NULL,
  `solicitante_edad` int(11) DEFAULT NULL,
  `solicitante_profesion` varchar(255) DEFAULT NULL,
  `solicitante_fecha_nacimiento` date DEFAULT NULL,
  `solicitante_telefono` varchar(20) DEFAULT NULL,
  `solicitante_correo` varchar(255) DEFAULT NULL,
  `solicitante_domicilio` varchar(255) DEFAULT NULL,
  `conviviente_nombre_completo` varchar(255) NOT NULL,
  `conviviente_ci` varchar(20) NOT NULL,
  `conviviente_fecha_nacimiento` date DEFAULT NULL,
  `conviviente_telefono` varchar(20) DEFAULT NULL,
  `conviviente_correo` varchar(255) DEFAULT NULL,
  `conviviente_domicilio` varchar(255) DEFAULT NULL,
  `conviviente_edad` int(11) DEFAULT NULL,
  `conviviente_profesion` varchar(255) DEFAULT NULL,
  `fecha_inicio_convivencia` date DEFAULT NULL,
  `tiempo_convivencia` varchar(255) DEFAULT NULL,
  `conviven_actualmente` tinyint(1) NOT NULL DEFAULT 1,
  `tienen_hijos` tinyint(1) NOT NULL DEFAULT 0,
  `cantidad_hijos` smallint(5) UNSIGNED DEFAULT 0,
  `tienen_bienes` tinyint(1) NOT NULL DEFAULT 0,
  `bienes_comunes` text DEFAULT NULL,
  `tipo_proceso` enum('reconocimiento','disolucion') NOT NULL,
  `domicilio_procesal` text DEFAULT NULL,
  `correo_procesal` varchar(255) DEFAULT NULL,
  `texto_demanda_disolucion` text DEFAULT NULL,
  `rpa` varchar(255) DEFAULT NULL,
  `ciudad` text DEFAULT NULL,
  `abogado_id` bigint(20) UNSIGNED NOT NULL,
  `estado_proceso` enum('pendiente','en_proceso','finalizado') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provisional`
--

CREATE TABLE `provisional` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asistencia_id` bigint(20) UNSIGNED NOT NULL,
  `numero_expediente` varchar(255) NOT NULL,
  `juez` varchar(255) NOT NULL,
  `fecha_admision` date NOT NULL,
  `concepto_medida` varchar(255) NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `plazo` varchar(255) NOT NULL,
  `forma_pago` varchar(255) NOT NULL,
  `documento_respaldo` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pruebas`
--

CREATE TABLE `pruebas` (
  `id_prueba` bigint(20) UNSIGNED NOT NULL,
  `proceso_type` varchar(255) NOT NULL,
  `proceso_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_prueba` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_presentacion` date NOT NULL,
  `estado_prueba` enum('admitida','rechazada','en valoración','incorporada') NOT NULL DEFAULT 'en valoración',
  `valor_probatorio` enum('alta','media','baja') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba_asistencia`
--

CREATE TABLE `prueba_asistencia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asistencia_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo_asistencia` enum('menores','mayores','conyuge','abuelos') NOT NULL,
  `certificado_nacimiento` varchar(255) DEFAULT NULL,
  `recibos_escolares` varchar(255) DEFAULT NULL,
  `testigos` varchar(255) DEFAULT NULL,
  `empleador` varchar(255) DEFAULT NULL,
  `sueldo` decimal(10,2) DEFAULT NULL,
  `certificado_estudios` varchar(255) DEFAULT NULL,
  `recibos_matricula` varchar(255) DEFAULT NULL,
  `informe_medico` varchar(255) DEFAULT NULL,
  `certificado_matrimonio` varchar(255) DEFAULT NULL,
  `certificados_medicos` varchar(255) DEFAULT NULL,
  `informes_ingresos` varchar(255) DEFAULT NULL,
  `certificados_nacimiento_abuelos` varchar(255) DEFAULT NULL,
  `informes_medicos_abuelos` varchar(255) DEFAULT NULL,
  `testimonios` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reconocimientos_union_libre`
--

CREATE TABLE `reconocimientos_union_libre` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proceso_union_libre_id` bigint(20) UNSIGNED NOT NULL,
  `nacionalidad_conviviente_1` varchar(255) DEFAULT NULL,
  `estado_civil_anterior_1` varchar(255) DEFAULT NULL,
  `nacionalidad_conviviente_2` varchar(255) DEFAULT NULL,
  `estado_civil_anterior_2` varchar(255) DEFAULT NULL,
  `lugar_convivencia` varchar(255) DEFAULT NULL,
  `pruebas_convivencia` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pruebas_convivencia`)),
  `pruebas_otros_texto` text DEFAULT NULL,
  `motivacion_reconocimiento` text DEFAULT NULL,
  `modalidad_tramite` enum('notarial','judicial') DEFAULT NULL,
  `lugar_solicitud` varchar(255) DEFAULT NULL,
  `fecha_solicitud` date DEFAULT NULL,
  `testigo1_nombre` varchar(255) DEFAULT NULL,
  `testigo1_ci` varchar(255) DEFAULT NULL,
  `testigo1_telefono` varchar(255) DEFAULT NULL,
  `testigo1_relacion` varchar(255) DEFAULT NULL,
  `testigo2_nombre` varchar(255) DEFAULT NULL,
  `testigo2_ci` varchar(255) DEFAULT NULL,
  `testigo2_telefono` varchar(255) DEFAULT NULL,
  `testigo2_relacion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reconocimientos_voluntarios`
--

CREATE TABLE `reconocimientos_voluntarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_padre` varchar(255) NOT NULL,
  `ci_padre` varchar(255) NOT NULL,
  `domicilio_padre` varchar(255) NOT NULL,
  `nombre_madre` varchar(255) NOT NULL,
  `ci_madre` varchar(255) NOT NULL,
  `domicilio_madre` varchar(255) NOT NULL,
  `nombre_hijo` varchar(255) NOT NULL,
  `apellidos_hijo` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `ciudad_nacimiento` varchar(255) NOT NULL,
  `provincia_nacimiento` varchar(255) NOT NULL,
  `nombre_testigo1` varchar(255) NOT NULL,
  `ci_testigo1` varchar(255) NOT NULL,
  `ocupacion_testigo1` varchar(255) NOT NULL,
  `nombre_testigo2` varchar(255) NOT NULL,
  `ci_testigo2` varchar(255) NOT NULL,
  `ocupacion_testigo2` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resoluciones_guardas`
--

CREATE TABLE `resoluciones_guardas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contestacion_guarda_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_resolucion` date NOT NULL,
  `numero_expediente` varchar(255) DEFAULT NULL,
  `contenido_resolucion` text DEFAULT NULL,
  `estado_final` varchar(255) DEFAULT NULL,
  `archivo_resolucion` varchar(255) DEFAULT NULL,
  `notificado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resolucion_adopcion`
--

CREATE TABLE `resolucion_adopcion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adopcion_id` bigint(20) UNSIGNED NOT NULL,
  `numero_resolucion` varchar(50) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `fecha_resolucion` date NOT NULL,
  `seguimiento` tinyint(1) NOT NULL DEFAULT 1,
  `observaciones` text DEFAULT NULL,
  `archivo_pdf` varchar(255) NOT NULL,
  `nombre_nna` varchar(150) NOT NULL,
  `ci_nna` varchar(20) DEFAULT NULL,
  `fecha_nacimiento_nna` date DEFAULT NULL,
  `edad_nna` int(11) DEFAULT NULL,
  `sexo_nna` varchar(10) DEFAULT NULL,
  `declaratoria_adoptabilidad` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `robo`
--

CREATE TABLE `robo` (
  `id_robo` bigint(20) UNSIGNED NOT NULL,
  `penal_ordinario_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_hecho` date NOT NULL,
  `lugar_hecho` varchar(255) NOT NULL,
  `relato_hechos` text NOT NULL,
  `bien_robado` varchar(255) NOT NULL,
  `valor_estimado` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `robo_testigo`
--

CREATE TABLE `robo_testigo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_robo` bigint(20) UNSIGNED NOT NULL,
  `id_testigo` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento_guarda`
--

CREATE TABLE `seguimiento_guarda` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guarda_custodia_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `supervision` varchar(255) NOT NULL,
  `cumple_regimen` tinyint(1) NOT NULL DEFAULT 0,
  `incumplimiento_visitas` enum('si','no') NOT NULL DEFAULT 'no',
  `medidas_correctivas` text DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento_judicial`
--

CREATE TABLE `seguimiento_judicial` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proceso_id` bigint(20) UNSIGNED NOT NULL,
  `otra_parte_acepta` tinyint(1) DEFAULT NULL,
  `audiencia_conciliacion` tinyint(1) DEFAULT NULL,
  `fecha_audiencia` date DEFAULT NULL,
  `juzgado_asignado` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sentencias`
--

CREATE TABLE `sentencias` (
  `id_sentencia` bigint(20) UNSIGNED NOT NULL,
  `tipo_proceso` varchar(100) NOT NULL,
  `proceso_id` bigint(20) UNSIGNED NOT NULL,
  `numero_sentencia` varchar(100) DEFAULT NULL,
  `fecha_sentencia` date DEFAULT NULL,
  `juez` varchar(150) DEFAULT NULL,
  `custodia_otorgada_a` varchar(100) DEFAULT NULL,
  `condiciones_regimen_visitas` text DEFAULT NULL,
  `documento_sentencia` varchar(255) DEFAULT NULL,
  `caso_sentenciado` tinyint(1) NOT NULL DEFAULT 0,
  `estado_sentencia` varchar(100) DEFAULT NULL,
  `pena_impuesta` varchar(255) DEFAULT NULL,
  `fecha_inicio_ejecucion` date DEFAULT NULL,
  `fecha_fin_ejecucion` date DEFAULT NULL,
  `medida_adoptada` varchar(255) DEFAULT NULL,
  `hecho_admitido` text DEFAULT NULL,
  `pena_solicitada` int(11) DEFAULT NULL,
  `unidad_pena_solicitada` enum('días','meses','años') DEFAULT NULL,
  `pena_dictada` int(11) DEFAULT NULL,
  `unidad_pena_dictada` enum('días','meses','años') DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sentencias_inmediatas`
--

CREATE TABLE `sentencias_inmediatas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_inmediato_id` bigint(20) UNSIGNED NOT NULL,
  `resultado` enum('Condena','Absolución','Medida alternativa') NOT NULL,
  `pena_medida` text DEFAULT NULL,
  `costas` decimal(10,2) DEFAULT NULL,
  `fecha_notificacion` date DEFAULT NULL,
  `sentencia_pdf` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sentencias_union_libre`
--

CREATE TABLE `sentencias_union_libre` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proceso_union_libre_id` bigint(20) UNSIGNED NOT NULL,
  `veredicto` enum('reconocimiento','disolucion','negacion') NOT NULL,
  `estado_sentencia` enum('pendiente','ejecutoriada') NOT NULL DEFAULT 'pendiente',
  `archivo_sentencia` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JhRAKoMRzWSK0gSOUFaHTH9loVi2slwNabNHyqx9', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZGtVMURTMlJzQXJ2QTFBNk45RkJKV3RmbkdkZ2ZWNm9yTk9xNjFqZiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovL2xvY2FsaG9zdC9idWZldC9wdWJsaWMvY2FycGV0YXMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MDoiaHR0cDovL2xvY2FsaG9zdC9idWZldC9wdWJsaWMvZG9jdW1lbnRvcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1757645772);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_procedimiento`
--

CREATE TABLE `solicitudes_procedimiento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penal_inmediato_id` bigint(20) UNSIGNED NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `fundamento` text NOT NULL,
  `requisitos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requisitos`)),
  `resumen_hechos` text NOT NULL,
  `evidencias` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`evidencias`)),
  `fecha_envio` timestamp NULL DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_evidencia`
--

CREATE TABLE `solicitud_evidencia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `solicitud_id` bigint(20) UNSIGNED NOT NULL,
  `evidencia_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifas`
--

CREATE TABLE `tarifas` (
  `id_tarifa` bigint(20) UNSIGNED NOT NULL,
  `proceso` enum('Penal','Civil','Familiar') NOT NULL,
  `tipo_proceso` varchar(255) NOT NULL,
  `etapa_proceso` varchar(255) DEFAULT NULL,
  `monto_min` decimal(8,2) NOT NULL,
  `monto_max` decimal(8,2) NOT NULL,
  `forma_pago` varchar(255) NOT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testigos`
--

CREATE TABLE `testigos` (
  `id_testigo` bigint(20) UNSIGNED NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `ci` varchar(255) NOT NULL,
  `expedido` varchar(2) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `ocupacion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL,
  `relacion` varchar(255) DEFAULT NULL,
  `relacion_con_partes` text DEFAULT NULL,
  `declaracion` text DEFAULT NULL,
  `fecha_declaracion` date DEFAULT NULL,
  `tipo_testigo` enum('presencial','perito','documental','referencia','experto') NOT NULL,
  `estado` enum('pendiente','aceptado','rechazado','no compareció') NOT NULL,
  `notificado` enum('si','no','pendiente') NOT NULL,
  `tipo_proceso` enum('familiar','penal','civil') NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `union_libre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'gimena', 'gimena123@gmail.com', NULL, '$2y$12$qU6RRD53B5gCHq2BRRD8zuWKAnHcixLEHzG41WrslqvoyDtojijRO', NULL, '2025-09-12 03:37:10', '2025-09-12 03:37:10'),
(2, 'anahi', 'anahi123@gmail.com', NULL, '$2y$12$rUL3iLUopGlsD2Dfkghw1eHqjByUKuoGFxsUhfNTRV38FRcCvSh5.', NULL, '2025-09-12 06:07:27', '2025-09-12 06:07:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ci` varchar(255) NOT NULL,
  `rol` enum('administrador','abogado','secretario','cliente','user') DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nombre`, `ci`, `rol`, `direccion`, `telefono`, `fecha_creacion`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'gimena', '10464723', 'cliente', 'Desconocida', NULL, '2025-09-12 03:37:10', 'gimena123@gmail.com', '$2y$12$mmPSeyyaM6wi5Lqb/6Yd9uetH6YRQYw7xyzAp.7xgNw8c.xE9HUTq', NULL, NULL),
(2, 'anahi', '1045698', 'cliente', 'Desconocida', NULL, '2025-09-12 06:07:27', 'anahi123@gmail.com', '$2y$12$6mQ4IDVpPSLdtRP2GH1DNuLelUpvzoTXYTGFi4P08aUBu0AAL8NDq', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `victimas`
--

CREATE TABLE `victimas` (
  `id_victima` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ci` varchar(15) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `zona` varchar(50) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `departamento` varchar(30) DEFAULT NULL,
  `estado_victima` varchar(20) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `violencias`
--

CREATE TABLE `violencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actuaciones`
--
ALTER TABLE `actuaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actuaciones_participante_id_foreign` (`participante_id`);

--
-- Indices de la tabla `acusaciones_rapidas`
--
ALTER TABLE `acusaciones_rapidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acusaciones_rapidas_asignacion_institucional_id_foreign` (`asignacion_institucional_id`),
  ADD KEY `acusaciones_rapidas_procedimiento_inmediato_id_foreign` (`procedimiento_inmediato_id`);

--
-- Indices de la tabla `acusacion_evidencia`
--
ALTER TABLE `acusacion_evidencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acusacion_evidencia_acusacion_rapida_id_foreign` (`acusacion_rapida_id`),
  ADD KEY `acusacion_evidencia_evidencia_id_foreign` (`evidencia_id`);

--
-- Indices de la tabla `adopciones`
--
ALTER TABLE `adopciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adopciones_solicitante1_id_foreign` (`solicitante1_id`),
  ADD KEY `adopciones_solicitante2_id_foreign` (`solicitante2_id`),
  ADD KEY `adopciones_id_abogado_foreign` (`id_abogado`);

--
-- Indices de la tabla `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id_agenda`),
  ADD KEY `agendas_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `anotaciones`
--
ALTER TABLE `anotaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anotaciones_asistencia_id_foreign` (`asistencia_id`),
  ADD KEY `anotaciones_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `apelaciones`
--
ALTER TABLE `apelaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apelaciones_sentencia_inmediata_id_foreign` (`sentencia_inmediata_id`);

--
-- Indices de la tabla `apelacions`
--
ALTER TABLE `apelacions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apelacions_guarda_id_foreign` (`guarda_id`);

--
-- Indices de la tabla `archivos_reconocimiento`
--
ALTER TABLE `archivos_reconocimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archivos_reconocimiento_reconocimiento_id_foreign` (`reconocimiento_id`);

--
-- Indices de la tabla `asignaciones_institucionales`
--
ALTER TABLE `asignaciones_institucionales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asignaciones_institucionales_penal_inmediato_id_foreign` (`penal_inmediato_id`),
  ADD KEY `asignaciones_institucionales_fiscal_id_foreign` (`fiscal_id`),
  ADD KEY `asignaciones_institucionales_juez_id_foreign` (`juez_id`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asistencias_demandante_id_foreign` (`demandante_id`),
  ADD KEY `asistencias_demandado_id_foreign` (`demandado_id`),
  ADD KEY `asistencias_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `asistencia_adulto`
--
ALTER TABLE `asistencia_adulto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asistencia_adulto_asistencia_id_unique` (`asistencia_id`);

--
-- Indices de la tabla `asistencia_conyuge`
--
ALTER TABLE `asistencia_conyuge`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asistencia_conyuge_asistencia_id_unique` (`asistencia_id`);

--
-- Indices de la tabla `asistencia_familiar`
--
ALTER TABLE `asistencia_familiar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asistencia_familiar_numero_proceso_unique` (`numero_proceso`),
  ADD KEY `asistencia_familiar_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `asistencia_ordinaria`
--
ALTER TABLE `asistencia_ordinaria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asistencia_ordinaria_asistencia_id_unique` (`asistencia_id`);

--
-- Indices de la tabla `asistencia_prenatal`
--
ALTER TABLE `asistencia_prenatal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asistencia_prenatal_asistencia_id_foreign` (`asistencia_id`);

--
-- Indices de la tabla `audiencias`
--
ALTER TABLE `audiencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audiencias_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `autoridades`
--
ALTER TABLE `autoridades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `autoridades_email_unique` (`email`);

--
-- Indices de la tabla `autos_admision`
--
ALTER TABLE `autos_admision`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_autos_admision_divorcio` (`divorcio_id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carpetas_padre_id_foreign` (`padre_id`),
  ADD KEY `carpetas_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `casos_penales`
--
ALTER TABLE `casos_penales`
  ADD PRIMARY KEY (`id_caso`),
  ADD KEY `casos_penales_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `caso_denunciados`
--
ALTER TABLE `caso_denunciados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caso_denunciados_caso_id_foreign` (`caso_id`),
  ADD KEY `caso_denunciados_persona_id_foreign` (`persona_id`);

--
-- Indices de la tabla `caso_denunciantes`
--
ALTER TABLE `caso_denunciantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caso_denunciantes_caso_id_foreign` (`caso_id`),
  ADD KEY `caso_denunciantes_persona_id_foreign` (`persona_id`);

--
-- Indices de la tabla `caso_testigos`
--
ALTER TABLE `caso_testigos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caso_testigos_caso_id_foreign` (`caso_id`),
  ADD KEY `caso_testigos_testigo_id_foreign` (`testigo_id`);

--
-- Indices de la tabla `cesacion_asistencia`
--
ALTER TABLE `cesacion_asistencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citas_cliente_id_foreign` (`cliente_id`),
  ADD KEY `citas_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `cita_documentos`
--
ALTER TABLE `cita_documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cita_documentos_cita_id_foreign` (`cita_id`);

--
-- Indices de la tabla `civil`
--
ALTER TABLE `civil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `civil_cases`
--
ALTER TABLE `civil_cases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `civil_cases_nro_expediente_unique` (`nro_expediente`);

--
-- Indices de la tabla `contestaciones`
--
ALTER TABLE `contestaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contestaciones_filiacion_id_foreign` (`filiacion_id`),
  ADD KEY `contestaciones_demandante_id_foreign` (`demandante_id`),
  ADD KEY `contestaciones_demandado_id_foreign` (`demandado_id`);

--
-- Indices de la tabla `contestacion_guarda`
--
ALTER TABLE `contestacion_guarda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contestacion_guarda_numero_proceso_unique` (`numero_proceso`),
  ADD KEY `contestacion_guarda_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `convenios_reguladores`
--
ALTER TABLE `convenios_reguladores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `convenios_reguladores_convenioable_type_convenioable_id_index` (`convenioable_type`,`convenioable_id`);

--
-- Indices de la tabla `coordinaciones`
--
ALTER TABLE `coordinaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coordinaciones_penal_inmediato_id_foreign` (`penal_inmediato_id`),
  ADD KEY `coordinaciones_autoridad_id_foreign` (`autoridad_id`);

--
-- Indices de la tabla `cumplimiento_guarda`
--
ALTER TABLE `cumplimiento_guarda`
  ADD PRIMARY KEY (`id_cumplimiento`),
  ADD KEY `cumplimiento_guarda_guarda_custodia_id_foreign` (`guarda_custodia_id`);

--
-- Indices de la tabla `demandas`
--
ALTER TABLE `demandas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `demandas_adopcion`
--
ALTER TABLE `demandas_adopcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demandas_adopcion_adopcion_id_foreign` (`adopcion_id`);

--
-- Indices de la tabla `demandas_guardas`
--
ALTER TABLE `demandas_guardas`
  ADD PRIMARY KEY (`id_demanda`),
  ADD KEY `demandas_guardas_id_solicitante_foreign` (`id_solicitante`),
  ADD KEY `demandas_guardas_id_menor_foreign` (`id_menor`),
  ADD KEY `demandas_guardas_id_demandado_foreign` (`id_demandado`);

--
-- Indices de la tabla `demandas_incumplimiento`
--
ALTER TABLE `demandas_incumplimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `disoluciones_union_libre`
--
ALTER TABLE `disoluciones_union_libre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disoluciones_union_libre_proceso_union_libre_id_foreign` (`proceso_union_libre_id`),
  ADD KEY `disoluciones_union_libre_testigo1_id_foreign` (`testigo1_id`),
  ADD KEY `disoluciones_union_libre_testigo2_id_foreign` (`testigo2_id`);

--
-- Indices de la tabla `divorcios`
--
ALTER TABLE `divorcios`
  ADD PRIMARY KEY (`id_divorcio`),
  ADD KEY `divorcios_conyuge1_id_foreign` (`conyuge1_id`),
  ADD KEY `divorcios_conyuge2_id_foreign` (`conyuge2_id`),
  ADD KEY `divorcios_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `divorcio_contenciosos`
--
ALTER TABLE `divorcio_contenciosos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divorcio_contenciosos_divorcio_id_foreign` (`divorcio_id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id_documento`),
  ADD KEY `documentos_carpeta_id_foreign` (`carpeta_id`);

--
-- Indices de la tabla `ejecuciones`
--
ALTER TABLE `ejecuciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ejecuciones_penal_abreviado_id_foreign` (`penal_abreviado_id`);

--
-- Indices de la tabla `ejecuciones_sentencia`
--
ALTER TABLE `ejecuciones_sentencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ejecuciones_sentencia_penal_sustancia_id_foreign` (`penal_sustancia_id`);

--
-- Indices de la tabla `estrategia_defensa`
--
ALTER TABLE `estrategia_defensa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estrategia_defensa_penal_sustancia_id_foreign` (`penal_sustancia_id`);

--
-- Indices de la tabla `etapas_intermedias`
--
ALTER TABLE `etapas_intermedias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etapas_intermedias_penal_sustancia_id_foreign` (`penal_sustancia_id`);

--
-- Indices de la tabla `etapas_investigativas`
--
ALTER TABLE `etapas_investigativas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etapas_investigativas_penal_sustancia_id_foreign` (`penal_sustancia_id`);

--
-- Indices de la tabla `evaluaciones_adopciones`
--
ALTER TABLE `evaluaciones_adopciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluaciones_adopciones_adopcion_id_foreign` (`adopcion_id`);

--
-- Indices de la tabla `evaluaciones_juridicas`
--
ALTER TABLE `evaluaciones_juridicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluaciones_juridicas_asistencia_id_foreign` (`asistencia_id`);

--
-- Indices de la tabla `evaluaciones_legales`
--
ALTER TABLE `evaluaciones_legales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluaciones_legales_guarda_custodia_id_foreign` (`guarda_custodia_id`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evidencias_penal_inmediato_id_foreign` (`penal_inmediato_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `familiares`
--
ALTER TABLE `familiares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `filiaciones`
--
ALTER TABLE `filiaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filiaciones_cliente_id_foreign` (`cliente_id`),
  ADD KEY `filiaciones_id_abogado_foreign` (`id_abogado`);

--
-- Indices de la tabla `filiacion_judicial`
--
ALTER TABLE `filiacion_judicial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filiacion_judicial_id_demandante_foreign` (`id_demandante`),
  ADD KEY `filiacion_judicial_id_menor_foreign` (`id_menor`),
  ADD KEY `filiacion_judicial_id_demandado_foreign` (`id_demandado`),
  ADD KEY `filiacion_judicial_id_abogado_foreign` (`id_abogado`);

--
-- Indices de la tabla `guarda_custodias`
--
ALTER TABLE `guarda_custodias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guarda_custodias_solicitante_id_foreign` (`solicitante_id`),
  ADD KEY `guarda_custodias_menor_id_foreign` (`menor_id`),
  ADD KEY `guarda_custodias_progenitor_id_foreign` (`progenitor_id`),
  ADD KEY `guarda_custodias_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `hijos`
--
ALTER TABLE `hijos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `impugnaciones_filiacion`
--
ALTER TABLE `impugnaciones_filiacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `impugnaciones_filiacion_demandante_id_foreign` (`demandante_id`),
  ADD KEY `impugnaciones_filiacion_demandado_id_foreign` (`demandado_id`),
  ADD KEY `impugnaciones_filiacion_menor_id_foreign` (`menor_id`);

--
-- Indices de la tabla `imputaciones_medidas`
--
ALTER TABLE `imputaciones_medidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imputaciones_medidas_penal_sustancia_id_foreign` (`penal_sustancia_id`);

--
-- Indices de la tabla `imputados`
--
ALTER TABLE `imputados`
  ADD PRIMARY KEY (`id_imputado`);

--
-- Indices de la tabla `informes`
--
ALTER TABLE `informes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `informes_hijo_id_foreign` (`hijo_id`);

--
-- Indices de la tabla `investigaciones_incidentes`
--
ALTER TABLE `investigaciones_incidentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigaciones_incidentes_penal_sustancia_id_foreign` (`penal_sustancia_id`);

--
-- Indices de la tabla `investigacion_penal`
--
ALTER TABLE `investigacion_penal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `investigacion_penal_numero_expediente_unique` (`numero_expediente`),
  ADD KEY `investigacion_penal_id_penal_abreviado_foreign` (`id_penal_abreviado`),
  ADD KEY `investigacion_penal_id_autoridad_foreign` (`id_autoridad`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `juicio_orals`
--
ALTER TABLE `juicio_orals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `juicio_orals_penal_sustancia_id_foreign` (`penal_sustancia_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `negociacion_fiscal`
--
ALTER TABLE `negociacion_fiscal`
  ADD PRIMARY KEY (`id_negociacion_fiscal`),
  ADD KEY `negociacion_fiscal_id_penal_abreviado_foreign` (`id_penal_abreviado`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `notificaciones_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `notificaciones_judiciales`
--
ALTER TABLE `notificaciones_judiciales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notificaciones_judiciales_usuario_id_foreign` (`usuario_id`),
  ADD KEY `notificaciones_judiciales_filiacion_id_foreign` (`filiacion_id`);

--
-- Indices de la tabla `notificacion_divorcio`
--
ALTER TABLE `notificacion_divorcio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notificacion_divorcio_divorcio_id_foreign` (`divorcio_id`),
  ADD KEY `notificacion_divorcio_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `notificacion_guardas`
--
ALTER TABLE `notificacion_guardas`
  ADD PRIMARY KEY (`id_notificacion`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `pagos_usuario_id_foreign` (`usuario_id`),
  ADD KEY `pagos_tarifa_id_foreign` (`tarifa_id`);

--
-- Indices de la tabla `pagos_asistencias`
--
ALTER TABLE `pagos_asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pagos_asistencias_asistencia_id_foreign` (`asistencia_id`);

--
-- Indices de la tabla `participantes_proceso_penal`
--
ALTER TABLE `participantes_proceso_penal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participantes_proceso_penal_usuario_id_usuarios_foreign` (`usuario_id_usuarios`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `penales`
--
ALTER TABLE `penales`
  ADD PRIMARY KEY (`id_penal`),
  ADD UNIQUE KEY `penales_expediente_unique` (`expediente`);

--
-- Indices de la tabla `penal_abreviado`
--
ALTER TABLE `penal_abreviado`
  ADD PRIMARY KEY (`id_penal_abreviado`),
  ADD UNIQUE KEY `penal_abreviado_numero_caso_unique` (`numero_caso`),
  ADD KEY `penal_abreviado_id_abogado_foreign` (`id_abogado`),
  ADD KEY `penal_abreviado_id_persona_foreign` (`id_persona`);

--
-- Indices de la tabla `penal_denunciados`
--
ALTER TABLE `penal_denunciados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penal_denunciados_penal_id_foreign` (`penal_id`),
  ADD KEY `penal_denunciados_persona_id_foreign` (`persona_id`);

--
-- Indices de la tabla `penal_denunciantes`
--
ALTER TABLE `penal_denunciantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penal_denunciantes_penal_id_foreign` (`penal_id`),
  ADD KEY `penal_denunciantes_persona_id_foreign` (`persona_id`);

--
-- Indices de la tabla `penal_entrevista`
--
ALTER TABLE `penal_entrevista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penal_entrevista_penal_sustancia_id_foreign` (`penal_sustancia_id`);

--
-- Indices de la tabla `penal_inmediato`
--
ALTER TABLE `penal_inmediato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penal_inmediato_id_imputado_foreign` (`id_imputado`),
  ADD KEY `penal_inmediato_id_abogado_foreign` (`id_abogado`);

--
-- Indices de la tabla `penal_ordinario`
--
ALTER TABLE `penal_ordinario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penal_ordinario_id_abogado_foreign` (`id_abogado`);

--
-- Indices de la tabla `penal_sustancias`
--
ALTER TABLE `penal_sustancias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penal_sustancias_ci_unique` (`ci`),
  ADD KEY `penal_sustancias_id_abogado_foreign` (`id_abogado`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personas_ci_unique` (`ci`);

--
-- Indices de la tabla `plazos_judiciales`
--
ALTER TABLE `plazos_judiciales`
  ADD PRIMARY KEY (`id_plazo`);

--
-- Indices de la tabla `presentaciones_divorcio`
--
ALTER TABLE `presentaciones_divorcio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presentaciones_divorcio_divorcio_id_foreign` (`divorcio_id`);

--
-- Indices de la tabla `presentaciones_juzgado`
--
ALTER TABLE `presentaciones_juzgado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presentaciones_juzgado_divorcio_id_foreign` (`divorcio_id`);

--
-- Indices de la tabla `presentaciones_penales`
--
ALTER TABLE `presentaciones_penales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presentaciones_penales_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `procedimiento_inmediatos`
--
ALTER TABLE `procedimiento_inmediatos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `procedimiento_inmediatos_penal_inmediato_id_foreign` (`penal_inmediato_id`);

--
-- Indices de la tabla `procesos_union_libre`
--
ALTER TABLE `procesos_union_libre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `procesos_union_libre_abogado_id_foreign` (`abogado_id`);

--
-- Indices de la tabla `provisional`
--
ALTER TABLE `provisional`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provisional_numero_expediente_unique` (`numero_expediente`),
  ADD KEY `provisional_asistencia_id_foreign` (`asistencia_id`);

--
-- Indices de la tabla `pruebas`
--
ALTER TABLE `pruebas`
  ADD PRIMARY KEY (`id_prueba`),
  ADD KEY `pruebas_proceso_type_proceso_id_index` (`proceso_type`,`proceso_id`);

--
-- Indices de la tabla `prueba_asistencia`
--
ALTER TABLE `prueba_asistencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prueba_asistencia_asistencia_id_foreign` (`asistencia_id`);

--
-- Indices de la tabla `reconocimientos_union_libre`
--
ALTER TABLE `reconocimientos_union_libre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reconocimientos_union_libre_proceso_union_libre_id_foreign` (`proceso_union_libre_id`);

--
-- Indices de la tabla `reconocimientos_voluntarios`
--
ALTER TABLE `reconocimientos_voluntarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resoluciones_guardas`
--
ALTER TABLE `resoluciones_guardas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resoluciones_guardas_contestacion_guarda_id_foreign` (`contestacion_guarda_id`);

--
-- Indices de la tabla `resolucion_adopcion`
--
ALTER TABLE `resolucion_adopcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resolucion_adopcion_adopcion_id_foreign` (`adopcion_id`);

--
-- Indices de la tabla `robo`
--
ALTER TABLE `robo`
  ADD PRIMARY KEY (`id_robo`),
  ADD KEY `robo_penal_ordinario_id_foreign` (`penal_ordinario_id`);

--
-- Indices de la tabla `robo_testigo`
--
ALTER TABLE `robo_testigo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `robo_testigo_id_robo_foreign` (`id_robo`),
  ADD KEY `robo_testigo_id_testigo_foreign` (`id_testigo`);

--
-- Indices de la tabla `seguimiento_guarda`
--
ALTER TABLE `seguimiento_guarda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seguimiento_guarda_guarda_custodia_id_foreign` (`guarda_custodia_id`);

--
-- Indices de la tabla `seguimiento_judicial`
--
ALTER TABLE `seguimiento_judicial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seguimiento_judicial_proceso_id_index` (`proceso_id`);

--
-- Indices de la tabla `sentencias`
--
ALTER TABLE `sentencias`
  ADD PRIMARY KEY (`id_sentencia`),
  ADD KEY `sentencias_tipo_proceso_proceso_id_index` (`tipo_proceso`,`proceso_id`);

--
-- Indices de la tabla `sentencias_inmediatas`
--
ALTER TABLE `sentencias_inmediatas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sentencias_inmediatas_penal_inmediato_id_foreign` (`penal_inmediato_id`);

--
-- Indices de la tabla `sentencias_union_libre`
--
ALTER TABLE `sentencias_union_libre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sentencias_union_libre_proceso_union_libre_id_foreign` (`proceso_union_libre_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `solicitudes_procedimiento`
--
ALTER TABLE `solicitudes_procedimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitudes_procedimiento_penal_inmediato_id_foreign` (`penal_inmediato_id`);

--
-- Indices de la tabla `solicitud_evidencia`
--
ALTER TABLE `solicitud_evidencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitud_evidencia_solicitud_id_foreign` (`solicitud_id`),
  ADD KEY `solicitud_evidencia_evidencia_id_foreign` (`evidencia_id`);

--
-- Indices de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indices de la tabla `testigos`
--
ALTER TABLE `testigos`
  ADD PRIMARY KEY (`id_testigo`),
  ADD UNIQUE KEY `testigos_ci_unique` (`ci`),
  ADD KEY `testigos_union_libre_id_foreign` (`union_libre_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`),
  ADD UNIQUE KEY `usuarios_ci_unique` (`ci`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`);

--
-- Indices de la tabla `victimas`
--
ALTER TABLE `victimas`
  ADD PRIMARY KEY (`id_victima`);

--
-- Indices de la tabla `violencias`
--
ALTER TABLE `violencias`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actuaciones`
--
ALTER TABLE `actuaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `acusaciones_rapidas`
--
ALTER TABLE `acusaciones_rapidas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `acusacion_evidencia`
--
ALTER TABLE `acusacion_evidencia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `adopciones`
--
ALTER TABLE `adopciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id_agenda` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `anotaciones`
--
ALTER TABLE `anotaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `apelaciones`
--
ALTER TABLE `apelaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `apelacions`
--
ALTER TABLE `apelacions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `archivos_reconocimiento`
--
ALTER TABLE `archivos_reconocimiento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignaciones_institucionales`
--
ALTER TABLE `asignaciones_institucionales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia_adulto`
--
ALTER TABLE `asistencia_adulto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia_conyuge`
--
ALTER TABLE `asistencia_conyuge`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia_familiar`
--
ALTER TABLE `asistencia_familiar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia_ordinaria`
--
ALTER TABLE `asistencia_ordinaria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia_prenatal`
--
ALTER TABLE `asistencia_prenatal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `audiencias`
--
ALTER TABLE `audiencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `autoridades`
--
ALTER TABLE `autoridades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `autos_admision`
--
ALTER TABLE `autos_admision`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `casos_penales`
--
ALTER TABLE `casos_penales`
  MODIFY `id_caso` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caso_denunciados`
--
ALTER TABLE `caso_denunciados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caso_denunciantes`
--
ALTER TABLE `caso_denunciantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caso_testigos`
--
ALTER TABLE `caso_testigos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cesacion_asistencia`
--
ALTER TABLE `cesacion_asistencia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cita_documentos`
--
ALTER TABLE `cita_documentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `civil`
--
ALTER TABLE `civil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `civil_cases`
--
ALTER TABLE `civil_cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contestaciones`
--
ALTER TABLE `contestaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contestacion_guarda`
--
ALTER TABLE `contestacion_guarda`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `convenios_reguladores`
--
ALTER TABLE `convenios_reguladores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `coordinaciones`
--
ALTER TABLE `coordinaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cumplimiento_guarda`
--
ALTER TABLE `cumplimiento_guarda`
  MODIFY `id_cumplimiento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `demandas`
--
ALTER TABLE `demandas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `demandas_adopcion`
--
ALTER TABLE `demandas_adopcion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `demandas_guardas`
--
ALTER TABLE `demandas_guardas`
  MODIFY `id_demanda` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `demandas_incumplimiento`
--
ALTER TABLE `demandas_incumplimiento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `disoluciones_union_libre`
--
ALTER TABLE `disoluciones_union_libre`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `divorcios`
--
ALTER TABLE `divorcios`
  MODIFY `id_divorcio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `divorcio_contenciosos`
--
ALTER TABLE `divorcio_contenciosos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id_documento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ejecuciones`
--
ALTER TABLE `ejecuciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejecuciones_sentencia`
--
ALTER TABLE `ejecuciones_sentencia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estrategia_defensa`
--
ALTER TABLE `estrategia_defensa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etapas_intermedias`
--
ALTER TABLE `etapas_intermedias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etapas_investigativas`
--
ALTER TABLE `etapas_investigativas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evaluaciones_adopciones`
--
ALTER TABLE `evaluaciones_adopciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evaluaciones_juridicas`
--
ALTER TABLE `evaluaciones_juridicas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evaluaciones_legales`
--
ALTER TABLE `evaluaciones_legales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `familiares`
--
ALTER TABLE `familiares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `filiaciones`
--
ALTER TABLE `filiaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `filiacion_judicial`
--
ALTER TABLE `filiacion_judicial`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guarda_custodias`
--
ALTER TABLE `guarda_custodias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hijos`
--
ALTER TABLE `hijos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `impugnaciones_filiacion`
--
ALTER TABLE `impugnaciones_filiacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imputaciones_medidas`
--
ALTER TABLE `imputaciones_medidas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imputados`
--
ALTER TABLE `imputados`
  MODIFY `id_imputado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informes`
--
ALTER TABLE `informes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `investigaciones_incidentes`
--
ALTER TABLE `investigaciones_incidentes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `investigacion_penal`
--
ALTER TABLE `investigacion_penal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `juicio_orals`
--
ALTER TABLE `juicio_orals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `negociacion_fiscal`
--
ALTER TABLE `negociacion_fiscal`
  MODIFY `id_negociacion_fiscal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones_judiciales`
--
ALTER TABLE `notificaciones_judiciales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion_divorcio`
--
ALTER TABLE `notificacion_divorcio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion_guardas`
--
ALTER TABLE `notificacion_guardas`
  MODIFY `id_notificacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos_asistencias`
--
ALTER TABLE `pagos_asistencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `participantes_proceso_penal`
--
ALTER TABLE `participantes_proceso_penal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `penales`
--
ALTER TABLE `penales`
  MODIFY `id_penal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `penal_abreviado`
--
ALTER TABLE `penal_abreviado`
  MODIFY `id_penal_abreviado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `penal_denunciados`
--
ALTER TABLE `penal_denunciados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `penal_denunciantes`
--
ALTER TABLE `penal_denunciantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `penal_entrevista`
--
ALTER TABLE `penal_entrevista`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `penal_inmediato`
--
ALTER TABLE `penal_inmediato`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `penal_ordinario`
--
ALTER TABLE `penal_ordinario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `penal_sustancias`
--
ALTER TABLE `penal_sustancias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plazos_judiciales`
--
ALTER TABLE `plazos_judiciales`
  MODIFY `id_plazo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presentaciones_divorcio`
--
ALTER TABLE `presentaciones_divorcio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presentaciones_juzgado`
--
ALTER TABLE `presentaciones_juzgado`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presentaciones_penales`
--
ALTER TABLE `presentaciones_penales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procedimiento_inmediatos`
--
ALTER TABLE `procedimiento_inmediatos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procesos_union_libre`
--
ALTER TABLE `procesos_union_libre`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `provisional`
--
ALTER TABLE `provisional`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pruebas`
--
ALTER TABLE `pruebas`
  MODIFY `id_prueba` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prueba_asistencia`
--
ALTER TABLE `prueba_asistencia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reconocimientos_union_libre`
--
ALTER TABLE `reconocimientos_union_libre`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reconocimientos_voluntarios`
--
ALTER TABLE `reconocimientos_voluntarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resoluciones_guardas`
--
ALTER TABLE `resoluciones_guardas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resolucion_adopcion`
--
ALTER TABLE `resolucion_adopcion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `robo`
--
ALTER TABLE `robo`
  MODIFY `id_robo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `robo_testigo`
--
ALTER TABLE `robo_testigo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seguimiento_guarda`
--
ALTER TABLE `seguimiento_guarda`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seguimiento_judicial`
--
ALTER TABLE `seguimiento_judicial`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sentencias`
--
ALTER TABLE `sentencias`
  MODIFY `id_sentencia` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sentencias_inmediatas`
--
ALTER TABLE `sentencias_inmediatas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sentencias_union_libre`
--
ALTER TABLE `sentencias_union_libre`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes_procedimiento`
--
ALTER TABLE `solicitudes_procedimiento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud_evidencia`
--
ALTER TABLE `solicitud_evidencia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  MODIFY `id_tarifa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `testigos`
--
ALTER TABLE `testigos`
  MODIFY `id_testigo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `victimas`
--
ALTER TABLE `victimas`
  MODIFY `id_victima` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `violencias`
--
ALTER TABLE `violencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actuaciones`
--
ALTER TABLE `actuaciones`
  ADD CONSTRAINT `actuaciones_participante_id_foreign` FOREIGN KEY (`participante_id`) REFERENCES `participantes_proceso_penal` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `acusaciones_rapidas`
--
ALTER TABLE `acusaciones_rapidas`
  ADD CONSTRAINT `acusaciones_rapidas_asignacion_institucional_id_foreign` FOREIGN KEY (`asignacion_institucional_id`) REFERENCES `asignaciones_institucionales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `acusaciones_rapidas_procedimiento_inmediato_id_foreign` FOREIGN KEY (`procedimiento_inmediato_id`) REFERENCES `procedimiento_inmediatos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `acusacion_evidencia`
--
ALTER TABLE `acusacion_evidencia`
  ADD CONSTRAINT `acusacion_evidencia_acusacion_rapida_id_foreign` FOREIGN KEY (`acusacion_rapida_id`) REFERENCES `acusaciones_rapidas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `acusacion_evidencia_evidencia_id_foreign` FOREIGN KEY (`evidencia_id`) REFERENCES `evidencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `adopciones`
--
ALTER TABLE `adopciones`
  ADD CONSTRAINT `adopciones_id_abogado_foreign` FOREIGN KEY (`id_abogado`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE,
  ADD CONSTRAINT `adopciones_solicitante1_id_foreign` FOREIGN KEY (`solicitante1_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adopciones_solicitante2_id_foreign` FOREIGN KEY (`solicitante2_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `agendas_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL;

--
-- Filtros para la tabla `anotaciones`
--
ALTER TABLE `anotaciones`
  ADD CONSTRAINT `anotaciones_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL,
  ADD CONSTRAINT `anotaciones_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `apelaciones`
--
ALTER TABLE `apelaciones`
  ADD CONSTRAINT `apelaciones_sentencia_inmediata_id_foreign` FOREIGN KEY (`sentencia_inmediata_id`) REFERENCES `sentencias_inmediatas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `apelacions`
--
ALTER TABLE `apelacions`
  ADD CONSTRAINT `apelacions_guarda_id_foreign` FOREIGN KEY (`guarda_id`) REFERENCES `guarda_custodias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `archivos_reconocimiento`
--
ALTER TABLE `archivos_reconocimiento`
  ADD CONSTRAINT `archivos_reconocimiento_reconocimiento_id_foreign` FOREIGN KEY (`reconocimiento_id`) REFERENCES `reconocimientos_union_libre` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignaciones_institucionales`
--
ALTER TABLE `asignaciones_institucionales`
  ADD CONSTRAINT `asignaciones_institucionales_fiscal_id_foreign` FOREIGN KEY (`fiscal_id`) REFERENCES `autoridades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asignaciones_institucionales_juez_id_foreign` FOREIGN KEY (`juez_id`) REFERENCES `autoridades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asignaciones_institucionales_penal_inmediato_id_foreign` FOREIGN KEY (`penal_inmediato_id`) REFERENCES `penal_inmediato` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_demandado_id_foreign` FOREIGN KEY (`demandado_id`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asistencias_demandante_id_foreign` FOREIGN KEY (`demandante_id`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asistencias_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL;

--
-- Filtros para la tabla `asistencia_adulto`
--
ALTER TABLE `asistencia_adulto`
  ADD CONSTRAINT `asistencia_adulto_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asistencia_conyuge`
--
ALTER TABLE `asistencia_conyuge`
  ADD CONSTRAINT `asistencia_conyuge_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asistencia_familiar`
--
ALTER TABLE `asistencia_familiar`
  ADD CONSTRAINT `asistencia_familiar_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asistencia_ordinaria`
--
ALTER TABLE `asistencia_ordinaria`
  ADD CONSTRAINT `asistencia_ordinaria_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asistencia_prenatal`
--
ALTER TABLE `asistencia_prenatal`
  ADD CONSTRAINT `asistencia_prenatal_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `audiencias`
--
ALTER TABLE `audiencias`
  ADD CONSTRAINT `audiencias_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL;

--
-- Filtros para la tabla `autos_admision`
--
ALTER TABLE `autos_admision`
  ADD CONSTRAINT `fk_autos_admision_divorcio` FOREIGN KEY (`divorcio_id`) REFERENCES `divorcios` (`id_divorcio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD CONSTRAINT `carpetas_padre_id_foreign` FOREIGN KEY (`padre_id`) REFERENCES `carpetas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carpetas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `casos_penales`
--
ALTER TABLE `casos_penales`
  ADD CONSTRAINT `casos_penales_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `caso_denunciados`
--
ALTER TABLE `caso_denunciados`
  ADD CONSTRAINT `caso_denunciados_caso_id_foreign` FOREIGN KEY (`caso_id`) REFERENCES `casos_penales` (`id_caso`) ON DELETE CASCADE,
  ADD CONSTRAINT `caso_denunciados_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `caso_denunciantes`
--
ALTER TABLE `caso_denunciantes`
  ADD CONSTRAINT `caso_denunciantes_caso_id_foreign` FOREIGN KEY (`caso_id`) REFERENCES `casos_penales` (`id_caso`) ON DELETE CASCADE,
  ADD CONSTRAINT `caso_denunciantes_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `caso_testigos`
--
ALTER TABLE `caso_testigos`
  ADD CONSTRAINT `caso_testigos_caso_id_foreign` FOREIGN KEY (`caso_id`) REFERENCES `casos_penales` (`id_caso`) ON DELETE CASCADE,
  ADD CONSTRAINT `caso_testigos_testigo_id_foreign` FOREIGN KEY (`testigo_id`) REFERENCES `testigos` (`id_testigo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `citas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cita_documentos`
--
ALTER TABLE `cita_documentos`
  ADD CONSTRAINT `cita_documentos_cita_id_foreign` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contestaciones`
--
ALTER TABLE `contestaciones`
  ADD CONSTRAINT `contestaciones_demandado_id_foreign` FOREIGN KEY (`demandado_id`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contestaciones_demandante_id_foreign` FOREIGN KEY (`demandante_id`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contestaciones_filiacion_id_foreign` FOREIGN KEY (`filiacion_id`) REFERENCES `filiaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contestacion_guarda`
--
ALTER TABLE `contestacion_guarda`
  ADD CONSTRAINT `contestacion_guarda_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL;

--
-- Filtros para la tabla `coordinaciones`
--
ALTER TABLE `coordinaciones`
  ADD CONSTRAINT `coordinaciones_autoridad_id_foreign` FOREIGN KEY (`autoridad_id`) REFERENCES `autoridades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coordinaciones_penal_inmediato_id_foreign` FOREIGN KEY (`penal_inmediato_id`) REFERENCES `penal_inmediato` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cumplimiento_guarda`
--
ALTER TABLE `cumplimiento_guarda`
  ADD CONSTRAINT `cumplimiento_guarda_guarda_custodia_id_foreign` FOREIGN KEY (`guarda_custodia_id`) REFERENCES `guarda_custodias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `demandas_adopcion`
--
ALTER TABLE `demandas_adopcion`
  ADD CONSTRAINT `demandas_adopcion_adopcion_id_foreign` FOREIGN KEY (`adopcion_id`) REFERENCES `adopciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `demandas_guardas`
--
ALTER TABLE `demandas_guardas`
  ADD CONSTRAINT `demandas_guardas_id_demandado_foreign` FOREIGN KEY (`id_demandado`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `demandas_guardas_id_menor_foreign` FOREIGN KEY (`id_menor`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `demandas_guardas_id_solicitante_foreign` FOREIGN KEY (`id_solicitante`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `disoluciones_union_libre`
--
ALTER TABLE `disoluciones_union_libre`
  ADD CONSTRAINT `disoluciones_union_libre_proceso_union_libre_id_foreign` FOREIGN KEY (`proceso_union_libre_id`) REFERENCES `procesos_union_libre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disoluciones_union_libre_testigo1_id_foreign` FOREIGN KEY (`testigo1_id`) REFERENCES `testigos` (`id_testigo`) ON DELETE SET NULL,
  ADD CONSTRAINT `disoluciones_union_libre_testigo2_id_foreign` FOREIGN KEY (`testigo2_id`) REFERENCES `testigos` (`id_testigo`) ON DELETE SET NULL;

--
-- Filtros para la tabla `divorcios`
--
ALTER TABLE `divorcios`
  ADD CONSTRAINT `divorcios_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE,
  ADD CONSTRAINT `divorcios_conyuge1_id_foreign` FOREIGN KEY (`conyuge1_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `divorcios_conyuge2_id_foreign` FOREIGN KEY (`conyuge2_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `divorcio_contenciosos`
--
ALTER TABLE `divorcio_contenciosos`
  ADD CONSTRAINT `divorcio_contenciosos_divorcio_id_foreign` FOREIGN KEY (`divorcio_id`) REFERENCES `divorcios` (`id_divorcio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_carpeta_id_foreign` FOREIGN KEY (`carpeta_id`) REFERENCES `carpetas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ejecuciones`
--
ALTER TABLE `ejecuciones`
  ADD CONSTRAINT `ejecuciones_penal_abreviado_id_foreign` FOREIGN KEY (`penal_abreviado_id`) REFERENCES `penal_abreviado` (`id_penal_abreviado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ejecuciones_sentencia`
--
ALTER TABLE `ejecuciones_sentencia`
  ADD CONSTRAINT `ejecuciones_sentencia_penal_sustancia_id_foreign` FOREIGN KEY (`penal_sustancia_id`) REFERENCES `penal_sustancias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `estrategia_defensa`
--
ALTER TABLE `estrategia_defensa`
  ADD CONSTRAINT `estrategia_defensa_penal_sustancia_id_foreign` FOREIGN KEY (`penal_sustancia_id`) REFERENCES `penal_sustancias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `etapas_intermedias`
--
ALTER TABLE `etapas_intermedias`
  ADD CONSTRAINT `etapas_intermedias_penal_sustancia_id_foreign` FOREIGN KEY (`penal_sustancia_id`) REFERENCES `penal_sustancias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `etapas_investigativas`
--
ALTER TABLE `etapas_investigativas`
  ADD CONSTRAINT `etapas_investigativas_penal_sustancia_id_foreign` FOREIGN KEY (`penal_sustancia_id`) REFERENCES `penal_sustancias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `evaluaciones_adopciones`
--
ALTER TABLE `evaluaciones_adopciones`
  ADD CONSTRAINT `evaluaciones_adopciones_adopcion_id_foreign` FOREIGN KEY (`adopcion_id`) REFERENCES `adopciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `evaluaciones_juridicas`
--
ALTER TABLE `evaluaciones_juridicas`
  ADD CONSTRAINT `evaluaciones_juridicas_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `evaluaciones_legales`
--
ALTER TABLE `evaluaciones_legales`
  ADD CONSTRAINT `evaluaciones_legales_guarda_custodia_id_foreign` FOREIGN KEY (`guarda_custodia_id`) REFERENCES `guarda_custodias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD CONSTRAINT `evidencias_penal_inmediato_id_foreign` FOREIGN KEY (`penal_inmediato_id`) REFERENCES `penal_inmediato` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `filiaciones`
--
ALTER TABLE `filiaciones`
  ADD CONSTRAINT `filiaciones_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE,
  ADD CONSTRAINT `filiaciones_id_abogado_foreign` FOREIGN KEY (`id_abogado`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `filiacion_judicial`
--
ALTER TABLE `filiacion_judicial`
  ADD CONSTRAINT `filiacion_judicial_id_abogado_foreign` FOREIGN KEY (`id_abogado`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE,
  ADD CONSTRAINT `filiacion_judicial_id_demandado_foreign` FOREIGN KEY (`id_demandado`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `filiacion_judicial_id_demandante_foreign` FOREIGN KEY (`id_demandante`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `filiacion_judicial_id_menor_foreign` FOREIGN KEY (`id_menor`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `guarda_custodias`
--
ALTER TABLE `guarda_custodias`
  ADD CONSTRAINT `guarda_custodias_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL,
  ADD CONSTRAINT `guarda_custodias_menor_id_foreign` FOREIGN KEY (`menor_id`) REFERENCES `hijos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guarda_custodias_progenitor_id_foreign` FOREIGN KEY (`progenitor_id`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `guarda_custodias_solicitante_id_foreign` FOREIGN KEY (`solicitante_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `impugnaciones_filiacion`
--
ALTER TABLE `impugnaciones_filiacion`
  ADD CONSTRAINT `impugnaciones_filiacion_demandado_id_foreign` FOREIGN KEY (`demandado_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `impugnaciones_filiacion_demandante_id_foreign` FOREIGN KEY (`demandante_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `impugnaciones_filiacion_menor_id_foreign` FOREIGN KEY (`menor_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `imputaciones_medidas`
--
ALTER TABLE `imputaciones_medidas`
  ADD CONSTRAINT `imputaciones_medidas_penal_sustancia_id_foreign` FOREIGN KEY (`penal_sustancia_id`) REFERENCES `penal_sustancias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `informes`
--
ALTER TABLE `informes`
  ADD CONSTRAINT `informes_hijo_id_foreign` FOREIGN KEY (`hijo_id`) REFERENCES `hijos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `investigaciones_incidentes`
--
ALTER TABLE `investigaciones_incidentes`
  ADD CONSTRAINT `investigaciones_incidentes_penal_sustancia_id_foreign` FOREIGN KEY (`penal_sustancia_id`) REFERENCES `penal_sustancias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `investigacion_penal`
--
ALTER TABLE `investigacion_penal`
  ADD CONSTRAINT `investigacion_penal_id_autoridad_foreign` FOREIGN KEY (`id_autoridad`) REFERENCES `autoridades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `investigacion_penal_id_penal_abreviado_foreign` FOREIGN KEY (`id_penal_abreviado`) REFERENCES `penal_abreviado` (`id_penal_abreviado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `juicio_orals`
--
ALTER TABLE `juicio_orals`
  ADD CONSTRAINT `juicio_orals_penal_sustancia_id_foreign` FOREIGN KEY (`penal_sustancia_id`) REFERENCES `penal_sustancias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `negociacion_fiscal`
--
ALTER TABLE `negociacion_fiscal`
  ADD CONSTRAINT `negociacion_fiscal_id_penal_abreviado_foreign` FOREIGN KEY (`id_penal_abreviado`) REFERENCES `penal_abreviado` (`id_penal_abreviado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones_judiciales`
--
ALTER TABLE `notificaciones_judiciales`
  ADD CONSTRAINT `notificaciones_judiciales_filiacion_id_foreign` FOREIGN KEY (`filiacion_id`) REFERENCES `filiaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificaciones_judiciales_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificacion_divorcio`
--
ALTER TABLE `notificacion_divorcio`
  ADD CONSTRAINT `notificacion_divorcio_divorcio_id_foreign` FOREIGN KEY (`divorcio_id`) REFERENCES `divorcios` (`id_divorcio`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificacion_divorcio_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_tarifa_id_foreign` FOREIGN KEY (`tarifa_id`) REFERENCES `tarifas` (`id_tarifa`) ON DELETE CASCADE,
  ADD CONSTRAINT `pagos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos_asistencias`
--
ALTER TABLE `pagos_asistencias`
  ADD CONSTRAINT `pagos_asistencias_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `participantes_proceso_penal`
--
ALTER TABLE `participantes_proceso_penal`
  ADD CONSTRAINT `participantes_proceso_penal_usuario_id_usuarios_foreign` FOREIGN KEY (`usuario_id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `penal_abreviado`
--
ALTER TABLE `penal_abreviado`
  ADD CONSTRAINT `penal_abreviado_id_abogado_foreign` FOREIGN KEY (`id_abogado`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE,
  ADD CONSTRAINT `penal_abreviado_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `penal_denunciados`
--
ALTER TABLE `penal_denunciados`
  ADD CONSTRAINT `penal_denunciados_penal_id_foreign` FOREIGN KEY (`penal_id`) REFERENCES `penal_ordinario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penal_denunciados_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `penal_denunciantes`
--
ALTER TABLE `penal_denunciantes`
  ADD CONSTRAINT `penal_denunciantes_penal_id_foreign` FOREIGN KEY (`penal_id`) REFERENCES `penal_ordinario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penal_denunciantes_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `penal_entrevista`
--
ALTER TABLE `penal_entrevista`
  ADD CONSTRAINT `penal_entrevista_penal_sustancia_id_foreign` FOREIGN KEY (`penal_sustancia_id`) REFERENCES `penal_sustancias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `penal_inmediato`
--
ALTER TABLE `penal_inmediato`
  ADD CONSTRAINT `penal_inmediato_id_abogado_foreign` FOREIGN KEY (`id_abogado`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL,
  ADD CONSTRAINT `penal_inmediato_id_imputado_foreign` FOREIGN KEY (`id_imputado`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `penal_ordinario`
--
ALTER TABLE `penal_ordinario`
  ADD CONSTRAINT `penal_ordinario_id_abogado_foreign` FOREIGN KEY (`id_abogado`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `penal_sustancias`
--
ALTER TABLE `penal_sustancias`
  ADD CONSTRAINT `penal_sustancias_id_abogado_foreign` FOREIGN KEY (`id_abogado`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL;

--
-- Filtros para la tabla `presentaciones_divorcio`
--
ALTER TABLE `presentaciones_divorcio`
  ADD CONSTRAINT `presentaciones_divorcio_divorcio_id_foreign` FOREIGN KEY (`divorcio_id`) REFERENCES `divorcios` (`id_divorcio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `presentaciones_juzgado`
--
ALTER TABLE `presentaciones_juzgado`
  ADD CONSTRAINT `presentaciones_juzgado_divorcio_id_foreign` FOREIGN KEY (`divorcio_id`) REFERENCES `divorcios` (`id_divorcio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `presentaciones_penales`
--
ALTER TABLE `presentaciones_penales`
  ADD CONSTRAINT `presentaciones_penales_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL;

--
-- Filtros para la tabla `procedimiento_inmediatos`
--
ALTER TABLE `procedimiento_inmediatos`
  ADD CONSTRAINT `procedimiento_inmediatos_penal_inmediato_id_foreign` FOREIGN KEY (`penal_inmediato_id`) REFERENCES `penal_inmediato` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `procesos_union_libre`
--
ALTER TABLE `procesos_union_libre`
  ADD CONSTRAINT `procesos_union_libre_abogado_id_foreign` FOREIGN KEY (`abogado_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE;

--
-- Filtros para la tabla `provisional`
--
ALTER TABLE `provisional`
  ADD CONSTRAINT `provisional_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prueba_asistencia`
--
ALTER TABLE `prueba_asistencia`
  ADD CONSTRAINT `prueba_asistencia_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reconocimientos_union_libre`
--
ALTER TABLE `reconocimientos_union_libre`
  ADD CONSTRAINT `reconocimientos_union_libre_proceso_union_libre_id_foreign` FOREIGN KEY (`proceso_union_libre_id`) REFERENCES `procesos_union_libre` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `resoluciones_guardas`
--
ALTER TABLE `resoluciones_guardas`
  ADD CONSTRAINT `resoluciones_guardas_contestacion_guarda_id_foreign` FOREIGN KEY (`contestacion_guarda_id`) REFERENCES `contestacion_guarda` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `resolucion_adopcion`
--
ALTER TABLE `resolucion_adopcion`
  ADD CONSTRAINT `resolucion_adopcion_adopcion_id_foreign` FOREIGN KEY (`adopcion_id`) REFERENCES `adopciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `robo`
--
ALTER TABLE `robo`
  ADD CONSTRAINT `robo_penal_ordinario_id_foreign` FOREIGN KEY (`penal_ordinario_id`) REFERENCES `penal_ordinario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `robo_testigo`
--
ALTER TABLE `robo_testigo`
  ADD CONSTRAINT `robo_testigo_id_robo_foreign` FOREIGN KEY (`id_robo`) REFERENCES `robo` (`id_robo`) ON DELETE CASCADE,
  ADD CONSTRAINT `robo_testigo_id_testigo_foreign` FOREIGN KEY (`id_testigo`) REFERENCES `testigos` (`id_testigo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `seguimiento_guarda`
--
ALTER TABLE `seguimiento_guarda`
  ADD CONSTRAINT `seguimiento_guarda_guarda_custodia_id_foreign` FOREIGN KEY (`guarda_custodia_id`) REFERENCES `guarda_custodias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sentencias_inmediatas`
--
ALTER TABLE `sentencias_inmediatas`
  ADD CONSTRAINT `sentencias_inmediatas_penal_inmediato_id_foreign` FOREIGN KEY (`penal_inmediato_id`) REFERENCES `penal_inmediato` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sentencias_union_libre`
--
ALTER TABLE `sentencias_union_libre`
  ADD CONSTRAINT `sentencias_union_libre_proceso_union_libre_id_foreign` FOREIGN KEY (`proceso_union_libre_id`) REFERENCES `procesos_union_libre` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitudes_procedimiento`
--
ALTER TABLE `solicitudes_procedimiento`
  ADD CONSTRAINT `solicitudes_procedimiento_penal_inmediato_id_foreign` FOREIGN KEY (`penal_inmediato_id`) REFERENCES `penal_inmediato` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitud_evidencia`
--
ALTER TABLE `solicitud_evidencia`
  ADD CONSTRAINT `solicitud_evidencia_evidencia_id_foreign` FOREIGN KEY (`evidencia_id`) REFERENCES `evidencias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitud_evidencia_solicitud_id_foreign` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes_procedimiento` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `testigos`
--
ALTER TABLE `testigos`
  ADD CONSTRAINT `testigos_union_libre_id_foreign` FOREIGN KEY (`union_libre_id`) REFERENCES `procesos_union_libre` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

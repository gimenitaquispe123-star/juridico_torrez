-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2025 a las 01:15:20
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
-- Estructura de tabla para la tabla `abogado_expediente`
--

CREATE TABLE `abogado_expediente` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_expediente` bigint(20) UNSIGNED NOT NULL,
  `id_empleado` bigint(20) UNSIGNED NOT NULL,
  `fecha_asignacion` date DEFAULT NULL,
  `fecha_desvinculacion` date DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_reg` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_mod` bigint(20) UNSIGNED DEFAULT NULL,
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
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

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:14:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:22:\"administracion sistema\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:16:\"gestion personas\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:13:\"tipos persona\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"lista empleados\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"expedientes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:16:\"gestion procesal\";s:1:\"c\";s:3:\"web\";}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:10:\"documentos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:21:\"seguimiento economico\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:6:\"agenda\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:26:\"plantillas e integraciones\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:17:\"eliminar clientes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"ver clientes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:13:\"ver empleados\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"editar clientes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"administrador\";s:1:\"c\";s:3:\"web\";}}}', 1764893615);

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
  `tipo_proceso_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proceso_id` bigint(20) UNSIGNED DEFAULT NULL,
  `registrado` timestamp NULL DEFAULT NULL,
  `modificado` timestamp NULL DEFAULT NULL,
  `usuario_reg` varchar(100) DEFAULT NULL,
  `usuario_mod` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED DEFAULT NULL,
  `id_empleado` bigint(20) UNSIGNED DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `nota` varchar(255) DEFAULT NULL,
  `asunto` varchar(255) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_hora_cita` datetime DEFAULT NULL,
  `lugar_cita` varchar(255) DEFAULT NULL,
  `estado_cita` varchar(50) NOT NULL DEFAULT 'Pendiente',
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_registrado` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_modificado` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_reg` varchar(50) NOT NULL,
  `usuario_mod` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id_documento` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_subida` datetime DEFAULT NULL,
  `texto_extraido` longtext DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `userid_sha256` varchar(255) DEFAULT NULL,
  `id_usuario` bigint(20) UNSIGNED DEFAULT NULL,
  `carpeta_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proceso_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expediente_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_plantilla`
--

CREATE TABLE `documento_plantilla` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `documento_id` bigint(20) UNSIGNED NOT NULL,
  `plantilla_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enlaces`
--

CREATE TABLE `enlaces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_persona` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `enlace` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_reg` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_mod` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enlaces_juridicos`
--

CREATE TABLE `enlaces_juridicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `enlace` text NOT NULL,
  `descripcion` text DEFAULT NULL,
  `registrado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `modificado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_proceso`
--

CREATE TABLE `estados_proceso` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estado_proceso` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_reg` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_mod` bigint(20) UNSIGNED DEFAULT NULL
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
  `color` varchar(255) DEFAULT '#3788d8',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes`
--

CREATE TABLE `expedientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED DEFAULT NULL,
  `codigo_expediente` varchar(50) NOT NULL,
  `nro_expediente` varchar(50) DEFAULT NULL,
  `demandante` varchar(150) DEFAULT NULL,
  `demandado` varchar(150) DEFAULT NULL,
  `materia` varchar(100) DEFAULT NULL,
  `contingencia` varchar(50) DEFAULT NULL,
  `respaldo` varchar(255) DEFAULT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_reg` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_mod` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `observaciones` text DEFAULT NULL,
  `estado_expediente` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes_digitalizados`
--

CREATE TABLE `expedientes_digitalizados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_expediente` bigint(20) UNSIGNED NOT NULL,
  `nro_expediente` varchar(255) NOT NULL,
  `tipo_expediente` enum('Publico','Privado') NOT NULL,
  `texto_expediente` text DEFAULT NULL,
  `url_documento` varchar(255) DEFAULT NULL,
  `usuario_reg` bigint(20) UNSIGNED NOT NULL,
  `usuario_mod` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes_documentos`
--

CREATE TABLE `expedientes_documentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_expediente` bigint(20) UNSIGNED NOT NULL,
  `documento_id` bigint(20) UNSIGNED NOT NULL,
  `observacion_descripcion` text DEFAULT NULL,
  `nombre_documento` varchar(255) DEFAULT NULL,
  `ruta_documento` varchar(255) DEFAULT NULL,
  `usuario_regi` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_modi` bigint(20) UNSIGNED DEFAULT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
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
-- Estructura de tabla para la tabla `mensajeria`
--

CREATE TABLE `mensajeria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED DEFAULT NULL,
  `id_empleado` bigint(20) UNSIGNED DEFAULT NULL,
  `asunto` varchar(150) NOT NULL,
  `mensaje` text NOT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_reg` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_mod` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
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
(4, '2025_01_05_173242_create_tipos_personas_table', 1),
(5, '2025_01_06_153245_create_personas_table', 1),
(6, '2025_01_06_162141_create_usuarios_table', 1),
(7, '2025_04_16_013844_create_tipos_procesos_table', 1),
(8, '2025_04_16_013845_create_tarifas_table', 1),
(9, '2025_04_17_144250_create_notificaciones_table', 1),
(10, '2025_05_03_190057_create_agendas_table', 1),
(11, '2025_08_29_181132_create_pagos_table', 1),
(12, '2025_09_10_185004_create_events_table', 1),
(13, '2025_09_11_212816_create_tipos_plantilla_table', 1),
(14, '2025_09_11_223822_create_expedientes_table', 1),
(15, '2025_09_11_223922_create_estados_proceso_table', 1),
(16, '2025_09_11_223922_create_posiciones_table', 1),
(17, '2025_09_11_223923_create_procesos_table', 1),
(18, '2025_09_11_223924_create_carpetas_table', 1),
(19, '2025_09_12_212813_create_documentos_table', 1),
(20, '2025_09_12_212814_create_plantillas_table', 1),
(21, '2025_10_08_224335_create_departamento_table', 1),
(22, '2025_10_08_225611_create_enlaces_table', 1),
(23, '2025_10_08_231749_create_mensajeria_table', 1),
(24, '2025_10_09_003529_create_abogado_expediente_table', 1),
(25, '2025_10_09_005156_create_expedientes_documentos_table', 1),
(26, '2025_10_11_015607_create_procesos_seguimiento_table', 1),
(27, '2025_10_14_012024_create_expedientes_digitalizados_table', 1),
(28, '2025_10_24_204048_create_recibos_pagos_table', 1),
(29, '2025_10_27_212051_create_citas_table', 1),
(30, '2025_11_18_235116_create_documento_plantilla_table', 1),
(31, '2025_11_25_135744_create_permission_tables', 1),
(32, '2025_11_27_182353_add_expediente_id_to_documentos_table', 1),
(33, '2025_12_02_162823_create_enlaces_juridicos_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Usuario', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` bigint(20) UNSIGNED NOT NULL,
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
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `tarifa_id` bigint(20) UNSIGNED NOT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `glosa_pago` text DEFAULT NULL,
  `monto_pagado` decimal(10,2) NOT NULL DEFAULT 0.00,
  `monto_pendiente` decimal(10,2) GENERATED ALWAYS AS (`monto_total` - `monto_pagado`) VIRTUAL,
  `fecha_pago` date DEFAULT NULL,
  `estado` enum('Pendiente','Pagado') NOT NULL DEFAULT 'Pendiente',
  `usuario_registro` bigint(20) UNSIGNED NOT NULL,
  `usuario_modifico` bigint(20) UNSIGNED DEFAULT NULL,
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
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'administracion sistema', 'web', '2025-12-03 23:52:34', '2025-12-03 23:52:34'),
(2, 'gestion personas', 'web', '2025-12-03 23:53:03', '2025-12-03 23:53:03'),
(3, 'tipos persona', 'web', '2025-12-03 23:53:26', '2025-12-03 23:53:26'),
(4, 'lista empleados', 'web', '2025-12-03 23:53:44', '2025-12-03 23:53:44'),
(5, 'expedientes', 'web', '2025-12-03 23:54:07', '2025-12-03 23:54:07'),
(6, 'gestion procesal', 'web', '2025-12-04 00:06:28', '2025-12-04 00:06:28'),
(7, 'documentos', 'web', '2025-12-04 00:06:51', '2025-12-04 00:06:51'),
(8, 'seguimiento economico', 'web', '2025-12-04 00:07:05', '2025-12-04 00:07:05'),
(9, 'agenda', 'web', '2025-12-04 00:07:21', '2025-12-04 00:07:21'),
(10, 'plantillas e integraciones', 'web', '2025-12-04 00:07:39', '2025-12-04 00:07:39'),
(11, 'eliminar clientes', 'web', '2025-12-04 00:10:20', '2025-12-04 00:10:20'),
(12, 'ver clientes', 'web', '2025-12-04 00:10:38', '2025-12-04 00:10:38'),
(13, 'ver empleados', 'web', '2025-12-04 00:10:48', '2025-12-04 00:10:48'),
(16, 'editar clientes', 'web', '2025-12-04 00:11:51', '2025-12-04 00:11:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_persona` bigint(20) UNSIGNED DEFAULT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `paterno` varchar(255) DEFAULT NULL,
  `materno` varchar(255) DEFAULT NULL,
  `ci` varchar(20) DEFAULT NULL,
  `ci_expedido` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `registrado` varchar(255) DEFAULT NULL,
  `modificado` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `matricula` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `usuario_reg` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_mod` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `id_tipo_persona`, `nombres`, `paterno`, `materno`, `ci`, `ci_expedido`, `celular`, `direccion`, `area`, `registrado`, `modificado`, `email`, `fecha_nacimiento`, `matricula`, `foto`, `usuario_reg`, `usuario_mod`, `created_at`, `updated_at`) VALUES
(1, 3, 'administrador', NULL, 'mamani', NULL, NULL, NULL, '4cgavcgjavhdirec', NULL, NULL, NULL, 'adm@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-04 00:00:18', '2025-12-04 00:00:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantillas`
--

CREATE TABLE `plantillas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_plantilla` bigint(20) UNSIGNED NOT NULL,
  `plantilla` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `ruta_archivo` varchar(255) DEFAULT NULL,
  `es_original` tinyint(1) NOT NULL DEFAULT 1,
  `id_plantilla_origen` bigint(20) UNSIGNED DEFAULT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_reg` varchar(255) DEFAULT NULL,
  `usuario_mod` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posiciones`
--

CREATE TABLE `posiciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos`
--

CREATE TABLE `procesos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED DEFAULT NULL,
  `id_abogado` bigint(20) UNSIGNED DEFAULT NULL,
  `id_posicion` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo_proceso` bigint(20) UNSIGNED DEFAULT NULL,
  `estado_proceso` bigint(20) UNSIGNED DEFAULT NULL,
  `id_expediente` bigint(20) UNSIGNED DEFAULT NULL,
  `contrario` varchar(255) DEFAULT NULL,
  `proceso` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `involucrados` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `usuario_reg` varchar(100) DEFAULT NULL,
  `usuario_mod` varchar(100) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos_seguimiento`
--

CREATE TABLE `procesos_seguimiento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_proceso` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha` date NOT NULL,
  `etapa` varchar(255) DEFAULT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `usuario_reg` bigint(20) UNSIGNED NOT NULL,
  `usuario_mod` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos_pagos`
--

CREATE TABLE `recibos_pagos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pago` bigint(20) UNSIGNED NOT NULL,
  `numero_recibo` varchar(255) NOT NULL,
  `glosa_pago` text DEFAULT NULL,
  `monto_pago` decimal(10,2) NOT NULL,
  `estado` enum('Emitido','Anulado') NOT NULL DEFAULT 'Emitido',
  `tipo_pago` enum('Efectivo','Transferencia','Cheque') NOT NULL,
  `usuario_registro` bigint(20) UNSIGNED NOT NULL,
  `usuario_modifico` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'administrador', 'web', '2025-12-03 23:51:10', '2025-12-03 23:51:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(16, 1);

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
('DTOUVEsgL5lL5LGnWN0b6b2wrryWm8cAOCzILr2i', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSHRLOVQ0cmFKdm5oRFNDVGZ1VTY1TU11S1dYSEVaTWxnOGhydkFnRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3QvYnVmZXQvcHVibGljL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764807236);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifas`
--

CREATE TABLE `tarifas` (
  `id_tarifa` bigint(20) UNSIGNED NOT NULL,
  `tipo_proceso_id` bigint(20) UNSIGNED NOT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `monto_min` decimal(10,2) NOT NULL,
  `monto_max` decimal(10,2) NOT NULL,
  `moneda` varchar(255) NOT NULL DEFAULT 'Bs',
  `vigencia_inicio` date DEFAULT NULL,
  `vigencia_fin` date DEFAULT NULL,
  `registrado` timestamp NULL DEFAULT NULL,
  `modificado` timestamp NULL DEFAULT NULL,
  `usuario_reg` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario_mod` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_personas`
--

CREATE TABLE `tipos_personas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_persona` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_personas`
--

INSERT INTO `tipos_personas` (`id`, `tipo_persona`, `descripcion`, `registrado`, `modificado`, `estado`) VALUES
(1, 'cliente', NULL, '2025-12-03 23:50:27', NULL, 1),
(2, 'abogado', NULL, '2025-12-03 23:58:30', NULL, 1),
(3, 'administrador', NULL, '2025-12-03 23:58:40', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_plantilla`
--

CREATE TABLE `tipos_plantilla` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_plantilla` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_reg` varchar(255) DEFAULT NULL,
  `usuario_mod` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_procesos`
--

CREATE TABLE `tipos_procesos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_proceso` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `registrado` timestamp NULL DEFAULT NULL,
  `modificado` timestamp NULL DEFAULT NULL,
  `usuario_reg` varchar(100) DEFAULT NULL,
  `usuario_mod` varchar(100) DEFAULT NULL
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
  `rol` varchar(255) NOT NULL DEFAULT 'cliente',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `persona_id` bigint(20) UNSIGNED DEFAULT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` timestamp NULL DEFAULT NULL,
  `usuario_reg` varchar(100) DEFAULT NULL,
  `usuario_mod` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `persona_id`, `usuario`, `password`, `email`, `rol`, `estado`, `fecha_registro`, `modificado`, `usuario_reg`, `usuario_mod`, `created_at`, `updated_at`) VALUES
(1, 1, 'adm', '$2y$12$CCKDb4WgZepOAFv3y3D0kOdUDO1dcQiy3V/w1i9hoAIylmV3x2yY2', 'admi@tusistema.com', 'administrador', 'activo', '2025-12-04 00:01:22', NULL, 'sistema', NULL, '2025-12-04 00:01:22', '2025-12-04 00:01:22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abogado_expediente`
--
ALTER TABLE `abogado_expediente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `abogado_expediente_id_expediente_foreign` (`id_expediente`),
  ADD KEY `abogado_expediente_id_empleado_foreign` (`id_empleado`),
  ADD KEY `abogado_expediente_usuario_reg_foreign` (`usuario_reg`),
  ADD KEY `abogado_expediente_usuario_mod_foreign` (`usuario_mod`);

--
-- Indices de la tabla `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id_agenda`);

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
  ADD KEY `carpetas_tipo_proceso_id_foreign` (`tipo_proceso_id`),
  ADD KEY `carpetas_proceso_id_foreign` (`proceso_id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citas_id_cliente_foreign` (`id_cliente`),
  ADD KEY `citas_id_empleado_foreign` (`id_empleado`),
  ADD KEY `citas_usuario_registrado_foreign` (`usuario_registrado`),
  ADD KEY `citas_usuario_modificado_foreign` (`usuario_modificado`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departamento_codigo_unique` (`codigo`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id_documento`),
  ADD KEY `documentos_id_usuario_foreign` (`id_usuario`),
  ADD KEY `documentos_carpeta_id_foreign` (`carpeta_id`),
  ADD KEY `documentos_proceso_id_foreign` (`proceso_id`),
  ADD KEY `documentos_expediente_id_foreign` (`expediente_id`);

--
-- Indices de la tabla `documento_plantilla`
--
ALTER TABLE `documento_plantilla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documento_plantilla_documento_id_foreign` (`documento_id`),
  ADD KEY `documento_plantilla_plantilla_id_foreign` (`plantilla_id`);

--
-- Indices de la tabla `enlaces`
--
ALTER TABLE `enlaces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enlaces_usuario_reg_foreign` (`usuario_reg`),
  ADD KEY `enlaces_usuario_mod_foreign` (`usuario_mod`),
  ADD KEY `enlaces_id_persona_foreign` (`id_persona`);

--
-- Indices de la tabla `enlaces_juridicos`
--
ALTER TABLE `enlaces_juridicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enlaces_juridicos_registrado_por_foreign` (`registrado_por`),
  ADD KEY `enlaces_juridicos_modificado_por_foreign` (`modificado_por`);

--
-- Indices de la tabla `estados_proceso`
--
ALTER TABLE `estados_proceso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expedientes_codigo_expediente_unique` (`codigo_expediente`),
  ADD KEY `expedientes_id_cliente_foreign` (`id_cliente`),
  ADD KEY `expedientes_usuario_reg_foreign` (`usuario_reg`),
  ADD KEY `expedientes_usuario_mod_foreign` (`usuario_mod`);

--
-- Indices de la tabla `expedientes_digitalizados`
--
ALTER TABLE `expedientes_digitalizados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expedientes_digitalizados_id_cliente_foreign` (`id_cliente`),
  ADD KEY `expedientes_digitalizados_id_expediente_foreign` (`id_expediente`),
  ADD KEY `expedientes_digitalizados_usuario_reg_foreign` (`usuario_reg`),
  ADD KEY `expedientes_digitalizados_usuario_mod_foreign` (`usuario_mod`);

--
-- Indices de la tabla `expedientes_documentos`
--
ALTER TABLE `expedientes_documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expedientes_documentos_id_expediente_foreign` (`id_expediente`),
  ADD KEY `expedientes_documentos_documento_id_foreign` (`documento_id`),
  ADD KEY `expedientes_documentos_usuario_regi_foreign` (`usuario_regi`),
  ADD KEY `expedientes_documentos_usuario_modi_foreign` (`usuario_modi`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indices de la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajeria_usuario_reg_foreign` (`usuario_reg`),
  ADD KEY `mensajeria_usuario_mod_foreign` (`usuario_mod`),
  ADD KEY `mensajeria_id_cliente_index` (`id_cliente`),
  ADD KEY `mensajeria_id_empleado_index` (`id_empleado`),
  ADD KEY `mensajeria_registrado_index` (`registrado`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `pagos_id_cliente_foreign` (`id_cliente`),
  ADD KEY `pagos_tarifa_id_foreign` (`tarifa_id`),
  ADD KEY `pagos_usuario_registro_foreign` (`usuario_registro`),
  ADD KEY `pagos_usuario_modifico_foreign` (`usuario_modifico`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personas_ci_unique` (`ci`),
  ADD KEY `personas_id_tipo_persona_foreign` (`id_tipo_persona`);

--
-- Indices de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plantillas_id_tipo_plantilla_foreign` (`id_tipo_plantilla`);

--
-- Indices de la tabla `posiciones`
--
ALTER TABLE `posiciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `procesos`
--
ALTER TABLE `procesos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `procesos_id_cliente_foreign` (`id_cliente`),
  ADD KEY `procesos_id_abogado_foreign` (`id_abogado`),
  ADD KEY `procesos_id_posicion_foreign` (`id_posicion`),
  ADD KEY `procesos_tipo_proceso_foreign` (`tipo_proceso`),
  ADD KEY `procesos_estado_proceso_foreign` (`estado_proceso`),
  ADD KEY `procesos_id_expediente_foreign` (`id_expediente`);

--
-- Indices de la tabla `procesos_seguimiento`
--
ALTER TABLE `procesos_seguimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `procesos_seguimiento_id_proceso_foreign` (`id_proceso`),
  ADD KEY `procesos_seguimiento_id_cliente_foreign` (`id_cliente`),
  ADD KEY `procesos_seguimiento_usuario_reg_foreign` (`usuario_reg`),
  ADD KEY `procesos_seguimiento_usuario_mod_foreign` (`usuario_mod`);

--
-- Indices de la tabla `recibos_pagos`
--
ALTER TABLE `recibos_pagos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recibos_pagos_numero_recibo_unique` (`numero_recibo`),
  ADD KEY `recibos_pagos_id_pago_foreign` (`id_pago`),
  ADD KEY `recibos_pagos_usuario_registro_foreign` (`usuario_registro`),
  ADD KEY `recibos_pagos_usuario_modifico_foreign` (`usuario_modifico`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  ADD PRIMARY KEY (`id_tarifa`),
  ADD KEY `tarifas_tipo_proceso_id_foreign` (`tipo_proceso_id`),
  ADD KEY `tarifas_usuario_reg_foreign` (`usuario_reg`),
  ADD KEY `tarifas_usuario_mod_foreign` (`usuario_mod`);

--
-- Indices de la tabla `tipos_personas`
--
ALTER TABLE `tipos_personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_plantilla`
--
ALTER TABLE `tipos_plantilla`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_procesos`
--
ALTER TABLE `tipos_procesos`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_usuario_unique` (`usuario`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`),
  ADD KEY `usuarios_persona_id_foreign` (`persona_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abogado_expediente`
--
ALTER TABLE `abogado_expediente`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id_agenda` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id_documento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documento_plantilla`
--
ALTER TABLE `documento_plantilla`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enlaces`
--
ALTER TABLE `enlaces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enlaces_juridicos`
--
ALTER TABLE `enlaces_juridicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados_proceso`
--
ALTER TABLE `estados_proceso`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expedientes_digitalizados`
--
ALTER TABLE `expedientes_digitalizados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expedientes_documentos`
--
ALTER TABLE `expedientes_documentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `posiciones`
--
ALTER TABLE `posiciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procesos`
--
ALTER TABLE `procesos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procesos_seguimiento`
--
ALTER TABLE `procesos_seguimiento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recibos_pagos`
--
ALTER TABLE `recibos_pagos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  MODIFY `id_tarifa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_personas`
--
ALTER TABLE `tipos_personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipos_plantilla`
--
ALTER TABLE `tipos_plantilla`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_procesos`
--
ALTER TABLE `tipos_procesos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abogado_expediente`
--
ALTER TABLE `abogado_expediente`
  ADD CONSTRAINT `abogado_expediente_id_empleado_foreign` FOREIGN KEY (`id_empleado`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `abogado_expediente_id_expediente_foreign` FOREIGN KEY (`id_expediente`) REFERENCES `expedientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `abogado_expediente_usuario_mod_foreign` FOREIGN KEY (`usuario_mod`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `abogado_expediente_usuario_reg_foreign` FOREIGN KEY (`usuario_reg`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD CONSTRAINT `carpetas_padre_id_foreign` FOREIGN KEY (`padre_id`) REFERENCES `carpetas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carpetas_proceso_id_foreign` FOREIGN KEY (`proceso_id`) REFERENCES `procesos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `carpetas_tipo_proceso_id_foreign` FOREIGN KEY (`tipo_proceso_id`) REFERENCES `tipos_procesos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `citas_id_empleado_foreign` FOREIGN KEY (`id_empleado`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `citas_usuario_modificado_foreign` FOREIGN KEY (`usuario_modificado`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `citas_usuario_registrado_foreign` FOREIGN KEY (`usuario_registrado`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_carpeta_id_foreign` FOREIGN KEY (`carpeta_id`) REFERENCES `carpetas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documentos_expediente_id_foreign` FOREIGN KEY (`expediente_id`) REFERENCES `expedientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documentos_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documentos_proceso_id_foreign` FOREIGN KEY (`proceso_id`) REFERENCES `procesos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `documento_plantilla`
--
ALTER TABLE `documento_plantilla`
  ADD CONSTRAINT `documento_plantilla_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id_documento`) ON DELETE CASCADE,
  ADD CONSTRAINT `documento_plantilla_plantilla_id_foreign` FOREIGN KEY (`plantilla_id`) REFERENCES `plantillas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `enlaces`
--
ALTER TABLE `enlaces`
  ADD CONSTRAINT `enlaces_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enlaces_usuario_mod_foreign` FOREIGN KEY (`usuario_mod`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `enlaces_usuario_reg_foreign` FOREIGN KEY (`usuario_reg`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `enlaces_juridicos`
--
ALTER TABLE `enlaces_juridicos`
  ADD CONSTRAINT `enlaces_juridicos_modificado_por_foreign` FOREIGN KEY (`modificado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `enlaces_juridicos_registrado_por_foreign` FOREIGN KEY (`registrado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD CONSTRAINT `expedientes_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expedientes_usuario_mod_foreign` FOREIGN KEY (`usuario_mod`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expedientes_usuario_reg_foreign` FOREIGN KEY (`usuario_reg`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `expedientes_digitalizados`
--
ALTER TABLE `expedientes_digitalizados`
  ADD CONSTRAINT `expedientes_digitalizados_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expedientes_digitalizados_id_expediente_foreign` FOREIGN KEY (`id_expediente`) REFERENCES `expedientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expedientes_digitalizados_usuario_mod_foreign` FOREIGN KEY (`usuario_mod`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expedientes_digitalizados_usuario_reg_foreign` FOREIGN KEY (`usuario_reg`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `expedientes_documentos`
--
ALTER TABLE `expedientes_documentos`
  ADD CONSTRAINT `expedientes_documentos_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id_documento`) ON DELETE CASCADE,
  ADD CONSTRAINT `expedientes_documentos_id_expediente_foreign` FOREIGN KEY (`id_expediente`) REFERENCES `expedientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expedientes_documentos_usuario_modi_foreign` FOREIGN KEY (`usuario_modi`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expedientes_documentos_usuario_regi_foreign` FOREIGN KEY (`usuario_regi`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  ADD CONSTRAINT `mensajeria_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `mensajeria_id_empleado_foreign` FOREIGN KEY (`id_empleado`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `mensajeria_usuario_mod_foreign` FOREIGN KEY (`usuario_mod`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `mensajeria_usuario_reg_foreign` FOREIGN KEY (`usuario_reg`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pagos_tarifa_id_foreign` FOREIGN KEY (`tarifa_id`) REFERENCES `tarifas` (`id_tarifa`) ON DELETE CASCADE,
  ADD CONSTRAINT `pagos_usuario_modifico_foreign` FOREIGN KEY (`usuario_modifico`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `pagos_usuario_registro_foreign` FOREIGN KEY (`usuario_registro`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_id_tipo_persona_foreign` FOREIGN KEY (`id_tipo_persona`) REFERENCES `tipos_personas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `plantillas`
--
ALTER TABLE `plantillas`
  ADD CONSTRAINT `plantillas_id_tipo_plantilla_foreign` FOREIGN KEY (`id_tipo_plantilla`) REFERENCES `tipos_plantilla` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `procesos`
--
ALTER TABLE `procesos`
  ADD CONSTRAINT `procesos_estado_proceso_foreign` FOREIGN KEY (`estado_proceso`) REFERENCES `estados_proceso` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `procesos_id_abogado_foreign` FOREIGN KEY (`id_abogado`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `procesos_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `procesos_id_expediente_foreign` FOREIGN KEY (`id_expediente`) REFERENCES `expedientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `procesos_id_posicion_foreign` FOREIGN KEY (`id_posicion`) REFERENCES `posiciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `procesos_tipo_proceso_foreign` FOREIGN KEY (`tipo_proceso`) REFERENCES `tipos_procesos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `procesos_seguimiento`
--
ALTER TABLE `procesos_seguimiento`
  ADD CONSTRAINT `procesos_seguimiento_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `personas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `procesos_seguimiento_id_proceso_foreign` FOREIGN KEY (`id_proceso`) REFERENCES `procesos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `procesos_seguimiento_usuario_mod_foreign` FOREIGN KEY (`usuario_mod`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `procesos_seguimiento_usuario_reg_foreign` FOREIGN KEY (`usuario_reg`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recibos_pagos`
--
ALTER TABLE `recibos_pagos`
  ADD CONSTRAINT `recibos_pagos_id_pago_foreign` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`) ON DELETE CASCADE,
  ADD CONSTRAINT `recibos_pagos_usuario_modifico_foreign` FOREIGN KEY (`usuario_modifico`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `recibos_pagos_usuario_registro_foreign` FOREIGN KEY (`usuario_registro`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tarifas`
--
ALTER TABLE `tarifas`
  ADD CONSTRAINT `tarifas_tipo_proceso_id_foreign` FOREIGN KEY (`tipo_proceso_id`) REFERENCES `tipos_procesos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tarifas_usuario_mod_foreign` FOREIGN KEY (`usuario_mod`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tarifas_usuario_reg_foreign` FOREIGN KEY (`usuario_reg`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

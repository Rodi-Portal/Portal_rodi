<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Raíz física de storagetalentsafe.
 */
if (! function_exists('talentsafe_storage_root')) {
    function talentsafe_storage_root(): string
    {
        return rtrim(FCPATH, '/\\')
            . DIRECTORY_SEPARATOR
            . 'storagetalentsafe';
    }
}

/**
 * Convierte una ruta relativa de storagetalentsafe a ruta física.
 *
 * Ejemplo:
 * portales/1/_const/clientes/15/archivo.pdf
 */
if (! function_exists('talentsafe_storage_physical')) {
    function talentsafe_storage_physical(string $relative): string
    {
        $relative = trim(str_replace('\\', '/', $relative), '/');

        return talentsafe_storage_root()
            . DIRECTORY_SEPARATOR
            . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    }
}

/**
 * Ruta relativa canónica para una constancia de cliente.
 */
if (! function_exists('talentsafe_const_cliente_relative')) {
    function talentsafe_const_cliente_relative(
        int $idPortal,
        int $idCliente,
        string $archivo
    ): string {
        $archivo = basename(str_replace('\\', '/', trim($archivo)));

        if ($idPortal <= 0 || $idCliente <= 0 || $archivo === '') {
            return '';
        }

        return sprintf(
            'portales/%d/_const/clientes/%d/%s',
            $idPortal,
            $idCliente,
            $archivo
        );
    }
}

/**
 * Directorio físico donde deben escribirse nuevas constancias.
 */
if (! function_exists('talentsafe_const_cliente_upload_dir')) {
    function talentsafe_const_cliente_upload_dir(
        int $idPortal,
        int $idCliente
    ): string {
        $relative = sprintf(
            'portales/%d/_const/clientes/%d',
            $idPortal,
            $idCliente
        );

        return talentsafe_storage_physical($relative);
    }
}

/**
 * Lectura dual de constancias.
 *
 * Soporta:
 *
 * 1. BD nueva:
 *    portales/{portal}/_const/clientes/{cliente}/archivo.pdf
 *
 * 2. BD legacy:
 *    archivo.pdf
 *
 * Para valores legacy primero revisa si el archivo ya fue migrado
 * físicamente a storagetalentsafe y después cae a /_const/.
 */
if (! function_exists('talentsafe_const_cliente_resolve')) {
    function talentsafe_const_cliente_resolve(
        string $stored,
        int $idPortal = 0,
        int $idCliente = 0
    ): string {
        $stored = trim(str_replace('\\', '/', $stored));

        if ($stored === '') {
            return '';
        }

        // Ruta relativa nueva guardada en BD.
        if (strpos($stored, 'portales/') === 0) {
            $nuevo = talentsafe_storage_physical($stored);

            if (is_file($nuevo) && is_readable($nuevo)) {
                return str_replace('\\', '/', $nuevo);
            }

            /*
             * Durante transición, si BD ya tiene ruta nueva pero
             * por alguna razón falta la copia, intentar legacy
             * usando únicamente el nombre físico.
             */
            $archivo = basename($stored);
            $legacy  = rtrim(FCPATH, '/\\')
                . DIRECTORY_SEPARATOR
                . '_const'
                . DIRECTORY_SEPARATOR
                . $archivo;

            if (is_file($legacy) && is_readable($legacy)) {
                return str_replace('\\', '/', $legacy);
            }

            return str_replace('\\', '/', $nuevo);
        }

        // Valor legacy: solo nombre de archivo.
        $archivo = basename($stored);

        /*
         * Si los archivos ya fueron migrados pero BD todavía no,
         * intentar primero la ubicación nueva.
         */
        if ($idPortal > 0 && $idCliente > 0) {
            $relative = talentsafe_const_cliente_relative(
                $idPortal,
                $idCliente,
                $archivo
            );

            $nuevo = talentsafe_storage_physical($relative);

            if (is_file($nuevo) && is_readable($nuevo)) {
                return str_replace('\\', '/', $nuevo);
            }
        }

        $legacy = rtrim(FCPATH, '/\\')
            . DIRECTORY_SEPARATOR
            . '_const'
            . DIRECTORY_SEPARATOR
            . $archivo;

        return str_replace('\\', '/', $legacy);
    }
}

/**
 * Convierte una ruta relativa de storagetalentsafe a URL pública.
 * Codifica cada segmento pero conserva las diagonales.
 */
if (! function_exists('talentsafe_storage_public_url')) {
    function talentsafe_storage_public_url(string $relative): string
    {
        $relative = trim(str_replace('\\', '/', $relative), '/');

        if ($relative === '') {
            return '';
        }

        $segments = array_map(
            'rawurlencode',
            explode('/', $relative)
        );

        return rtrim(base_url('storagetalentsafe'), '/')
            . '/'
            . implode('/', $segments);
    }
}

/**
 * Ruta relativa canónica para un documento de aspirante de reclutamiento.
 *
 * documentos_aspirante.id_aspirante corresponde a requisicion_aspirante.id.
 *
 * Estructura:
 * portales/{portal}/reclutamiento/aspirantes/{requisicion_aspirante}/documentos/{archivo}
 */
if (! function_exists('talentsafe_aspirante_doc_relative')) {
    function talentsafe_aspirante_doc_relative(
        int $idPortal,
        int $idRequisicionAspirante,
        string $archivo
    ): string {
        $archivo = basename(
            str_replace('\\', '/', trim($archivo))
        );

        if (
            $idPortal <= 0
            || $idRequisicionAspirante <= 0
            || $archivo === ''
        ) {
            return '';
        }

        return sprintf(
            'portales/%d/reclutamiento/aspirantes/%d/documentos/%s',
            $idPortal,
            $idRequisicionAspirante,
            $archivo
        );
    }
}

/**
 * Directorio físico donde deben escribirse los nuevos documentos
 * de documentos_aspirante.
 */
if (! function_exists('talentsafe_aspirante_doc_upload_dir')) {
    function talentsafe_aspirante_doc_upload_dir(
        int $idPortal,
        int $idRequisicionAspirante
    ): string {
        if (
            $idPortal <= 0
            || $idRequisicionAspirante <= 0
        ) {
            return '';
        }

        $relative = sprintf(
            'portales/%d/reclutamiento/aspirantes/%d/documentos',
            $idPortal,
            $idRequisicionAspirante
        );

        return talentsafe_storage_physical($relative);
    }
}

/**
 * Resuelve un documento de aspirante con lectura dual.
 *
 * Orden:
 *
 * 1. Nueva estructura:
 *    storagetalentsafe/portales/{portal}/reclutamiento/
 *    aspirantes/{requisicion_aspirante}/documentos/{archivo}
 *
 * 2. Legacy:
 *    _docs/{archivo}
 *
 * También acepta en $stored una ruta relativa nueva que empiece
 * por "portales/" para mantener compatibilidad futura.
 */
if (! function_exists('talentsafe_aspirante_doc_resolve')) {
    function talentsafe_aspirante_doc_resolve(
        string $stored,
        int $idPortal = 0,
        int $idRequisicionAspirante = 0
    ): string {
        $stored = trim(
            str_replace('\\', '/', $stored)
        );

        if ($stored === '') {
            return '';
        }

        /*
         * Si la BD ya contiene una ruta relativa nueva.
         */
        if (strpos($stored, 'portales/') === 0) {
            return str_replace(
                '\\',
                '/',
                talentsafe_storage_physical($stored)
            );
        }

        /*
         * Esquema actual:
         * documentos_aspirante.nombre_archivo contiene
         * solamente el nombre físico.
         */
        $archivo = basename($stored);

        if (
            $idPortal <= 0
            || $idRequisicionAspirante <= 0
            || $archivo === ''
        ) {
            return '';
        }

        $relative = talentsafe_aspirante_doc_relative(
            $idPortal,
            $idRequisicionAspirante,
            $archivo
        );

        if ($relative === '') {
            return '';
        }

        return str_replace(
            '\\',
            '/',
            talentsafe_storage_physical($relative)
        );
    }
}


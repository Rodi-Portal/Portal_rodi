<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Términos y Condiciones | Aviso de Confidencialidad</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- Incluye tu CSS/Bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
  <style>
    .section-card { border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.06); }
    h1,h2,h3 { scroll-margin-top: 80px; }
    .muted { color:#6c757d; }
    .ol-tight > li { margin-bottom:.5rem; }
    .plan-table th, .plan-table td { vertical-align: middle; }
  </style>
</head>
<body>
<div class="container my-4 my-md-5">
  <header class="mb-4">
    <h1 class="mb-1">Términos y Condiciones</h1>
    <p class="muted mb-0">Última actualización: <?= date('F Y'); ?></p>
  </header>

  <!-- Tabla de Planes -->
  <div class="card section-card mb-4">
    <div class="card-body">
      <h2 class="h4">Planes y Módulos</h2>
      <p class="mb-3">La Plataforma ofrece los siguientes módulos: <strong>Reclutamiento, Preempleo, Empleados, Exempleados y Comunicación</strong>.</p>
      <div class="table-responsive">
        <table class="table table-bordered plan-table">
          <thead class="thead-light">
            <tr>
              <th>Plan</th>
              <th>Usuarios incluidos</th>
              <th>Módulos incluidos</th>
              <th>Precio mensual</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Light</strong></td>
              <td>1</td>
              <td>1 módulo (a elección)</td>
              <td>USD $80 / mes</td>
            </tr>
            <tr>
              <td><strong>Standard</strong></td>
              <td>5</td>
              <td>Empleados + Exempleados (incluye Comunicación)</td>
              <td>USD  130 / mes</td>
            </tr>
            <tr>
              <td><strong>Plus</strong></td>
              <td>5</td>
              <td>Los 5 módulos</td>
              <td>USD  250 / mes</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="mb-0"><small class="muted">Usuarios adicionales fuera del plan: <strong>USD $50/mes por usuario</strong> (se informa al momento de crearlos).</small></p>
    </div>
  </div>

  <!-- Terminos y Condiciones -->
  <div class="card section-card mb-5">
    <div class="card-body">
      <h2 class="h4">1. Objeto y Aceptación</h2>
      <ol class="ol-tight">
        <li>Estos Términos y Condiciones regulan el acceso y uso del Software TalentSafe® y sus módulos. Al crear una cuenta, acceder o utilizar el Software TalentSafe®, usted acepta íntegramente estos Términos.</li>
        <li>Si actúa en representación de una empresa, declara que cuenta con las facultades necesarias para obligarla en los términos aquí establecidos.</li>
      </ol>

      <h2 class="h4 mt-4">2. Planes, Precios y Usuarios Adicionales</h2>
      <ol class="ol-tight" start="3">
        <li>El Software TalentSafe® se contrata bajo modalidad de <strong>suscripción mensual</strong> por plan. Los planes y precios vigentes se publican en este sitio o se comunican por escrito al Cliente.</li>
        <li>Los <strong>usuarios adicionales</strong> no incluidos en el plan contratado tienen un costo de <strong>USD $50/mes por usuario</strong>. El sistema informa este costo al momento de su creación.</li>
      </ol>

      <h2 class="h4 mt-4">3. Ciclo de Facturación, Corte y Suspensión</h2>
      <ol class="ol-tight" start="5">
        <li>El <strong>día de corte</strong> es el <strong>día 1</strong> de cada mes. El servicio se factura por meses naturales.</li>
        <li>Si no se recibe el pago correspondiente, el <strong>acceso se retirará el día 6</strong> del mismo mes hasta que se regularice la situación.</li>
        <li>El Cliente puede optar por no continuar: “<em>“si lo quieres lo pagas”</em>”. En ausencia de pago, se aplicarán las políticas de suspensión y eliminación de datos descritas en estos Términos.</li>
      </ol>

      <h2 class="h4 mt-4">4. Conservación y Eliminación de Datos</h2>
      <ol class="ol-tight" start="8">
        <li>Ante la falta de pago, los datos permanecerán <strong>almacenados durante tres (3) meses</strong>. Transcurrido dicho periodo sin pago, la información podrá ser <strong>eliminada de forma irreversible</strong>.</li>
        <li>El Cliente es responsable de descargar y resguardar sus datos antes del vencimiento del periodo de retención. La Plataforma puede ofrecer exportaciones bajo solicitud del Cliente mientras exista acceso vigente.</li>
      </ol>

      <h2 class="h4 mt-4">5. Licencia de Uso y Propiedad Intelectual</h2>
      <ol class="ol-tight" start="10">
        <li>Se concede una <strong>licencia de uso limitada, no exclusiva e intransferible</strong> de la Plataforma mientras la suscripción esté vigente y al corriente.</li>
        <li>El software, marcas y materiales asociados son titularidad de sus respectivos propietarios y se encuentran protegidos por la legislación aplicable.</li>
      </ol>

      <h2 class="h4 mt-4">6. Seguridad, Confidencialidad y Soporte</h2>
      <ol class="ol-tight" start="12">
        <li>Se aplican medidas administrativas, técnicas y físicas razonables para proteger la confidencialidad e integridad de la información del Cliente.</li>
        <li>El Cliente es responsable de la correcta gestión de usuarios y contraseñas, así como de los permisos internos.</li>
        <li>La disponibilidad del servicio puede verse afectada por mantenimientos programados o causas de fuerza mayor. Cualquier ventana de mantenimiento se comunicará con antelación razonable, cuando sea posible.</li>
      </ol>

      <h2 class="h4 mt-4">7. Obligaciones del Cliente</h2>
      <ol class="ol-tight" start="15">
        <li>Utilizar la Plataforma conforme a la ley y a estos Términos.</li>
        <li>No intentar vulnerar la seguridad, extraer datos de terceros sin autorización ni usar la Plataforma para fines ilícitos.</li>
        <li>Proveer información veraz y mantenerla actualizada.</li>
      </ol>

      <h2 class="h4 mt-4">8. Limitación de Responsabilidad</h2>
      <ol class="ol-tight" start="18">
        <li>En la medida permitida por la ley, los proveedores de la Plataforma no serán responsables por daños indirectos, incidentales o consecuenciales derivados del uso o imposibilidad de uso del servicio.</li>
      </ol>

      <h2 class="h4 mt-4">9. Modificaciones</h2>
      <ol class="ol-tight" start="19">
        <li>Los presentes Términos podrán actualizarse. Los cambios sustanciales se notificarán por medios razonables. El uso continuado del Software TalentSafe® implica la aceptación de las modificaciones.</li>
      </ol>

      <h2 class="h4 mt-4">10. Ley Aplicable y Jurisdicción</h2>
      <ol class="ol-tight" start="20">
        <li>Estos Términos se rigen por las leyes de México. Para la interpretación y cumplimiento, las partes se someten a los tribunales competentes del domicilio del proveedor, renunciando a cualquier otro fuero.</li>
      </ol>

      <div class="mt-4 d-flex gap-2">
        <a href="<?= $terminos_url; ?>" class="btn btn-primary">
          Descargar Términos y Condiciones (PDF)
        </a>
      </div>
    </div>
  </div>

  <!-- Aviso de Confidencialidad -->
  <div class="card section-card mb-5">
    <div class="card-body">
      <h2 class="h4">Aviso de Confidencialidad</h2>
      <p>Este Aviso de Confidencialidad (“Aviso”) describe los lineamientos bajo los cuales el proveedor de la Plataforma resguarda la información a la que accede y que es proporcionada por el Cliente en el uso de los módulos de Reclutamiento, Preempleo, Empleados, Exempleados y Comunicación.</p>

      <h3 class="h5 mt-3">1. Alcance de la Información</h3>
      <p>La información puede incluir, de manera enunciativa, datos de identificación, laborales y de comunicación interna del Cliente, así como documentos que éste decida cargar en el Software TalentSafe®. El Cliente es responsable de obtener las autorizaciones internas y de terceros que correspondan.</p>

      <h3 class="h5 mt-3">2. Finalidades</h3>
      <p>La información se utiliza para la prestación de los servicios contratados, operación del Software TalentSafe®, soporte técnico, mejoras continuas y cumplimiento de obligaciones legales.</p>

      <h3 class="h5 mt-3">3. Medidas de Seguridad</h3>
      <p>Se aplican medidas razonables de seguridad administrativa, técnica y física para proteger la información contra acceso, uso o divulgación no autorizada. </p>

      <h3 class="h5 mt-3">4. Accesos y Confidencialidad</h3>
      <p>El personal y proveedores que, por función, accedan a la información se encuentran sujetos a obligaciones de confidencialidad. La información sólo se trata para los fines necesarios a la prestación del servicio.</p>

      <h3 class="h5 mt-3">5. Conservación y Eliminación</h3>
      <p>En caso de falta de pago, la información se conservará por un periodo de <strong>tres (3) meses</strong>. Transcurrido ese plazo sin regularización, la información podrá ser <strong>eliminada de forma irreversible</strong>, salvo obligación legal de conservación.</p>

      <h3 class="h5 mt-3">6. Transferencias y Encargados</h3>
      <p>Podrán realizarse transferencias o encargos de tratamiento estrictamente necesarios para la operación (p. ej., hosting o soporte), bajo condiciones de confidencialidad y seguridad equivalentes.</p>

      <h3 class="h5 mt-3">7. Contacto</h3>
      <p>Para dudas o solicitudes en materia de confidencialidad, favor de contactar al soporte indicado en el Software TalentSafe®.</p>

      <div class="mt-4 d-flex gap-2">
        <a href="<?= $confidencialidad_url; ?>" class="btn btn-outline-primary">
          Descargar Aviso de Confidencialidad (PDF)
        </a>
      </div>
    </div>
  </div>

  <footer class="text-center muted">
    &copy; <?= date('Y'); ?> — Plataforma de Gestión. Todos los derechos reservados.
  </footer>
</div>
</body>
</html>

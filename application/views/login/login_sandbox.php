<?php
    /**
 * Vista de registro DEMO TalentSafe (CodeIgniter 3)
 * Idiomas iniciales: es / en. Los valores del formulario y sus endpoints se mantienen.
 * URL: .../login/... ?lang=es | ?lang=en
 */
    $idiomaSolicitado = (isset($_GET['lang']) && is_string($_GET['lang']))
    ? strtolower(trim($_GET['lang']))
    : 'en';

    $lang = in_array($idiomaSolicitado, ['es', 'en'], true) ? $idiomaSolicitado : 'en';

    $translations = [
    'es' => [
        'pageTitle'                 => 'Acceso al DEMO | TalentSafe',
        'brandSubtitle'             => 'Gestión inteligente del talento',
        'languageLabel'             => 'Idioma',
        'eyebrow'                   => 'DESCUBRE TALENTSAFE',
        'heroTitle'                 => 'Tu talento merece una mejor forma de trabajar.',
        'heroDescription'           => 'Conoce cómo TalentSafe facilita cada etapa de la gestión de personas, desde el reclutamiento hasta el seguimiento de empleados.',
        'modulesTitle'              => 'Conoce nuestros módulos',
        'modulesDescription'        => 'Selecciona un módulo para descubrir sus funcionalidades.',
        'moduleRecruiting'          => 'Reclutamiento',
        'modulePreemployment'       => 'Pre-Empleo',
        'moduleEmployees'           => 'Empleados',
        'moduleFormerEmployees'     => 'Exempleados',
        'moduleRecruitingDesc'      => 'Organiza tus vacantes y candidatos.',
        'modulePreemploymentDesc'   => 'Evalúa antes de contratar.',
        'moduleEmployeesDesc'       => 'Centraliza la información laboral.',
        'moduleFormerEmployeesDesc' => 'Conserva el historial de bajas.',
        'formEyebrow'               => 'ACCESO AL DEMO',
        'formTitle'                 => 'Comienza con TalentSafe',
        'formDescription'           => 'Completa tus datos para solicitar acceso a la demostración.',
        'nameLabel'                 => 'Nombre',
        'namePlaceholder'           => 'Tu nombre',
        'phoneLabel'                => 'Teléfono',
        'phonePlaceholder'          => 'Tu teléfono',
        'emailLabel'                => 'Correo electrónico',
        'emailPlaceholder'          => 'nombre@empresa.com',
        'sourceLabel'               => '¿Cómo llegaste aquí?',
        'sourcePlaceholder'         => 'Selecciona una opción',
        'sourceGoogle'              => 'Google',
        'sourceSocial'              => 'Redes sociales',
        'sourceReferral'            => 'Recomendación',
        'sourceOther'               => 'Otro',
        'otherLabel'                => '¿De dónde nos contactas?',
        'otherPlaceholder'          => 'Escribe aquí...',
        'passwordLabel'             => 'Contraseña',
        'passwordPlaceholder'       => 'Crea una contraseña',
        'showPassword'              => 'Mostrar contraseña',
        'hidePassword'              => 'Ocultar contraseña',
        'submit'                    => 'Solicitar acceso',
        'sending'                   => 'Enviando...',
        'registeredQuestion'        => '¿Ya te registraste?',
        'loginLink'                 => 'Ingresa aquí',
        'featuresLabel'             => 'Características',
        'close'                     => 'Cerrar',
        'successTitle'              => '¡Formulario enviado exitosamente!',
        'successConfirm'            => '¡Genial!',
        'errorTitle'                => 'Error al enviar el formulario',
        'errorConfirm'              => 'Aceptar',
        'errorGeneric'              => 'Hubo un problema al intentar enviar el formulario. Inténtalo nuevamente.',
        'successFallback'           => 'Tu solicitud fue registrada correctamente.',
        'errorFallback'             => 'No pudimos procesar tu solicitud. Revisa la información e inténtalo nuevamente.',
        'recruitingF1'              => 'Gestión de vacantes',
        'recruitingF2'              => 'Publicación en diferentes portales de empleo',
        'recruitingF3'              => 'Proceso de selección completo',
        'recruitingF4'              => 'Integración con bases de datos de candidatos',
        'preemploymentF1'           => 'Evaluación de candidatos antes de la contratación',
        'preemploymentF2'           => 'Pruebas psicométricas y técnicas',
        'preemploymentF3'           => 'Documentación de pre-contratación',
        'preemploymentF4'           => 'Entrevistas y análisis de perfiles',
        'employeesF1'               => 'Gestión completa del ciclo del empleado',
        'employeesF2'               => 'Historial de empleo y desempeño',
        'employeesF3'               => 'Integración con el sistema de nómina',
        'employeesF4'               => 'Control de ausencias y permisos',
        'formerEmployeesF1'         => 'Control de salida de los empleados',
        'formerEmployeesF2'         => 'Documentación de finiquitos y cartas de recomendación',
        'formerEmployeesF3'         => 'Generación de reportes de exempleados',
        'formerEmployeesF4'         => 'Acceso a historial laboral',
        'moduleCommunication'       => 'Comunicación',
        'moduleCommunicationDesc'   => 'Comunicación Interna y Comunicación 360.',

        'commInternalTitle'         => 'Comunicación Interna',
        'commInternalF1'            => 'Prenómina',
        'commInternalF2'            => 'Calendario de eventos',
        'commInternalF3'            => 'Mensajería',
        'commInternalF4'            => 'Recordatorios',

        'comm360Title'              => 'Comunicación 360',
        'comm360F1'                 => 'Checador de asistencia',
        'comm360F2'                 => 'Accesos de colaboradores',
        'comm360F3'                 => 'Configuración de políticas de asistencia',
        'comm360F4'                 => 'Ubicaciones, horarios y métodos permitidos',
        'comm360F5'                 => 'Flujos de trabajo',
        'comm360F6'                 => 'Tareas',
        'comm360F7'                 => 'Reportes de asistencia',
    ],
    'en' => [
        'pageTitle'                 => 'Demo Access | TalentSafe',
        'brandSubtitle'             => 'Smarter talent management',
        'languageLabel'             => 'Language',
        'eyebrow'                   => 'DISCOVER TALENTSAFE',
        'heroTitle'                 => 'Your people deserve a better way to work.',
        'heroDescription'           => 'Discover how TalentSafe simplifies every stage of people management, from recruiting to employee management.',
        'modulesTitle'              => 'Explore our modules',
        'modulesDescription'        => 'Select a module to learn about its features.',
        'moduleRecruiting'          => 'Recruiting',
        'modulePreemployment'       => 'Pre-employment',
        'moduleEmployees'           => 'Employees',
        'moduleFormerEmployees'     => 'Former employees',
        'moduleRecruitingDesc'      => 'Organize vacancies and candidates.',
        'modulePreemploymentDesc'   => 'Assess candidates before hiring.',
        'moduleEmployeesDesc'       => 'Keep employee records in one place.',
        'moduleFormerEmployeesDesc' => 'Preserve offboarding records.',
        'formEyebrow'               => 'DEMO ACCESS',
        'formTitle'                 => 'Get started with TalentSafe',
        'formDescription'           => 'Enter your details to request access to the demo.',
        'nameLabel'                 => 'Name',
        'namePlaceholder'           => 'Your name',
        'phoneLabel'                => 'Phone',
        'phonePlaceholder'          => 'Your phone number',
        'emailLabel'                => 'Email address',
        'emailPlaceholder'          => 'name@company.com',
        'sourceLabel'               => 'How did you hear about us?',
        'sourcePlaceholder'         => 'Select an option',
        'sourceGoogle'              => 'Google',
        'sourceSocial'              => 'Social media',
        'sourceReferral'            => 'Referral',
        'sourceOther'               => 'Other',
        'otherLabel'                => 'Where did you hear about us?',
        'otherPlaceholder'          => 'Write here...',
        'passwordLabel'             => 'Password',
        'passwordPlaceholder'       => 'Create a password',
        'showPassword'              => 'Show password',
        'hidePassword'              => 'Hide password',
        'submit'                    => 'Request access',
        'sending'                   => 'Sending...',
        'registeredQuestion'        => 'Already registered?',
        'loginLink'                 => 'Sign in here',
        'featuresLabel'             => 'Features',
        'close'                     => 'Close',
        'successTitle'              => 'Your form was sent successfully!',
        'successConfirm'            => 'Great!',
        'errorTitle'                => 'Unable to submit the form',
        'errorConfirm'              => 'OK',
        'errorGeneric'              => 'There was a problem submitting your form. Please try again.',
        'successFallback'           => 'Your request was successfully received.',
        'errorFallback'             => 'We could not process your request. Review your information and try again.',
        'recruitingF1'              => 'Job opening management',
        'recruitingF2'              => 'Posting across job boards',
        'recruitingF3'              => 'Complete candidate selection process',
        'recruitingF4'              => 'Integration with candidate databases',
        'preemploymentF1'           => 'Candidate screening before hiring',
        'preemploymentF2'           => 'Psychometric and technical assessments',
        'preemploymentF3'           => 'Pre-employment documentation',
        'preemploymentF4'           => 'Interviews and candidate profile analysis',
        'employeesF1'               => 'End-to-end employee lifecycle management',
        'employeesF2'               => 'Employment and performance history',
        'employeesF3'               => 'Payroll system integration',
        'employeesF4'               => 'Absence and leave management',
        'formerEmployeesF1'         => 'Employee offboarding management',
        'formerEmployeesF2'         => 'Final settlement and reference documents',
        'formerEmployeesF3'         => 'Former employee reports',
        'formerEmployeesF4'         => 'Access to employment history',
        'moduleCommunication'       => 'Communication',
        'moduleCommunicationDesc'   => 'Internal Communication and Communication 360.',

        'commInternalTitle'         => 'Internal Communication',
        'commInternalF1'            => 'Pre-payroll',
        'commInternalF2'            => 'Events calendar',
        'commInternalF3'            => 'Messaging',
        'commInternalF4'            => 'Reminders',

        'comm360Title'              => 'Communication 360',
        'comm360F1'                 => 'Time and attendance tracking',
        'comm360F2'                 => 'Employee access management',
        'comm360F3'                 => 'Attendance policy configuration',
        'comm360F4'                 => 'Locations, schedules, and allowed check-in methods',
        'comm360F5'                 => 'Workflows',
        'comm360F6'                 => 'Tasks',
        'comm360F7'                 => 'Attendance reports',
    ],
    ];

    $t = function ($key) use (&$translations, &$lang) {
    return htmlspecialchars(isset($translations[$lang][$key]) ? $translations[$lang][$key] : $key, ENT_QUOTES, 'UTF-8');
    };

    $modules = [
    [
        'id'          => 'modalReclutamiento',
        'title'       => 'moduleRecruiting',
        'description' => 'moduleRecruitingDesc',
        'icon'        => 'fa-briefcase',
        'features'    => ['recruitingF1', 'recruitingF2', 'recruitingF3', 'recruitingF4'],
    ],
    [
        'id'          => 'modalPreEmpleo',
        'title'       => 'modulePreemployment',
        'description' => 'modulePreemploymentDesc',
        'icon'        => 'fa-user-check',
        'features'    => ['preemploymentF1', 'preemploymentF2', 'preemploymentF3', 'preemploymentF4'],
    ],
    [
        'id'          => 'modalEmpleados',
        'title'       => 'moduleEmployees',
        'description' => 'moduleEmployeesDesc',
        'icon'        => 'fa-users',
        'features'    => ['employeesF1', 'employeesF2', 'employeesF3', 'employeesF4'],
    ],
    [
        'id'          => 'modalExempleados',
        'title'       => 'moduleFormerEmployees',
        'description' => 'moduleFormerEmployeesDesc',
        'icon'        => 'fa-user-slash',
        'features'    => ['formerEmployeesF1', 'formerEmployeesF2', 'formerEmployeesF3', 'formerEmployeesF4'],
    ],
    [
        'id'          => 'modalComunicacion',
        'title'       => 'moduleCommunication',
        'description' => 'moduleCommunicationDesc',
        'icon'        => 'fa-comments',
        'groups'      => [
            [
                'title'    => 'commInternalTitle',
                'features' => [
                    'commInternalF1',
                    'commInternalF2',
                    'commInternalF3',
                    'commInternalF4',
                ],
            ],
            [
                'title'    => 'comm360Title',
                'features' => [
                    'comm360F1',
                    'comm360F2',
                    'comm360F3',
                    'comm360F4',
                    'comm360F5',
                    'comm360F6',
                    'comm360F7',
                ],
            ],
        ],
    ],
    ];

?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#f6f8fc">
  <title data-i18n="pageTitle"><?php echo $t('pageTitle'); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
  :root {
    --ts-blue: #2456e8;
    --ts-blue-dark: #173bb8;
    --ts-ink: #17243b;
    --ts-muted: #64748b;
    --ts-line: #e0e7f1;
    --ts-bg: #f6f8fc;
    --ts-gold: #cfab50;
  }

  *,
  *::before,
  *::after {
    box-sizing: border-box;
  }

  body.demo-page {
    margin: 0;
    min-height: 100vh;
    background: var(--ts-bg);
    color: var(--ts-ink);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 14px;
    line-height: 1.55;
    -webkit-font-smoothing: antialiased;
  }

  .demo-page button,
  .demo-page input,
  .demo-page select {
    font: inherit;
  }

  .demo-header {
    background: #fff;
    border-bottom: 1px solid var(--ts-line);
    box-shadow: 0 2px 14px rgba(20, 38, 66, .025);
  }

  .demo-header-inner {
    width: min(1160px, calc(100% - 48px));
    min-height: 78px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }

  .demo-brand {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none !important;
  }

  .demo-brand img {
    display: block;
    width: 45px;
    height: 45px;
    object-fit: contain;
  }

  .demo-brand-name {
    color: #182d72;
    font-size: 19px;
    font-weight: 800;
    letter-spacing: -.7px;
  }

  .demo-brand-name .reg {
    color: var(--ts-gold);
    font-size: 9px;
    vertical-align: top;
  }

  .demo-lang-wrap {
    display: flex;
    align-items: center;
    gap: 9px;
  }

  .demo-lang-wrap .fa-globe {
    color: #48627f;
  }

  .demo-lang-label {
    font-size: 13px;
    color: var(--ts-muted);
    margin: 0;
  }

  .demo-language {
    border: 1px solid var(--ts-line);
    border-radius: 10px;
    background: #fff;
    color: #27364f;
    padding: 10px 13px;
    font-weight: 600;
    min-width: 78px;
    cursor: pointer;
  }

  .demo-language:focus,
  .demo-page .demo-control:focus,
  .demo-page .demo-submit:focus-visible,
  .demo-page .demo-module:focus-visible,
  .demo-page .show-password:focus-visible {
    outline: 3px solid rgba(36, 86, 232, .18);
    outline-offset: 2px;
  }

  .demo-main {
    width: min(1160px, calc(100% - 48px));
    margin: 0 auto;
    padding: 60px 0 85px;
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(370px, 480px);
    align-items: start;
    gap: clamp(32px, 5vw, 80px);
  }

  .demo-story {
    padding-top: 26px;
  }

  .demo-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 16px;
    color: var(--ts-blue);
    font-weight: 700;
    font-size: 12px;
    letter-spacing: .075em;
  }

  .demo-eyebrow::before {
    content: '';
    width: 7px;
    height: 7px;
    background: var(--ts-gold);
    border-radius: 50%;
  }

  .demo-story h1 {
    font-size: clamp(33px, 3.6vw, 47px);
    line-height: 1.17;
    font-weight: 800;
    letter-spacing: -1.7px;
    margin: 0 0 22px;
    max-width: 580px;
  }

  .demo-story-lead {
    font-size: 16px;
    line-height: 1.8;
    color: var(--ts-muted);
    max-width: 560px;
    margin: 0 0 44px;
  }

  .demo-module-heading {
    font-size: 20px;
    line-height: 1.3;
    font-weight: 750;
    letter-spacing: -.5px;
    margin: 0 0 6px;
  }

  .demo-module-intro {
    color: var(--ts-muted);
    margin: 0 0 20px;
  }

  .demo-module-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 15px;
  }

  .demo-module {
    width: 100%;
    min-height: 164px;
    padding: 22px 20px;
    background: white;
    border: 1px solid var(--ts-line);
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(21, 41, 80, .045);
    text-align: left;
    cursor: pointer;
    transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease;
  }

  .demo-module:hover {
    transform: translateY(-3px);
    border-color: #c7d7fa;
    box-shadow: 0 12px 22px rgba(26, 55, 113, .09);
  }

  .demo-module-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    color: var(--ts-blue);
    background: #edf2ff;
    border-radius: 12px;
    font-size: 18px;
    margin-bottom: 16px;
  }

  .demo-module-title {
    display: block;
    margin-bottom: 4px;
    font-weight: 700;
    font-size: 14px;
  }

  .demo-module-desc {
    display: block;
    color: var(--ts-muted);
    font-size: 12px;
    line-height: 1.55;
  }

  .demo-form-card {
    background: #fff;
    border: 1px solid var(--ts-line);
    border-radius: 20px;
    box-shadow: 0 16px 48px rgba(18, 39, 79, .075);
    padding: 38px 34px 31px;
  }

  .demo-form-eyebrow {
    color: var(--ts-blue);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .095em;
    margin: 0 0 10px;
  }

  .demo-form-card h2 {
    font-size: 26px;
    font-weight: 800;
    line-height: 1.25;
    letter-spacing: -.9px;
    margin: 0 0 9px;
  }

  .demo-form-intro {
    color: var(--ts-muted);
    margin: 0 0 26px;
    line-height: 1.65;
  }

  .demo-fields {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 17px 16px;
  }

  .demo-field {
    min-width: 0;
  }

  .demo-field-wide {
    grid-column: 1 / -1;
  }

  .demo-field label {
    display: block;
    margin: 0 0 7px;
    font-size: 12px;
    font-weight: 650;
    color: #33445e;
  }

  .demo-page .demo-control {
    width: 100%;
    height: 44px;
    padding: 10px 12px;
    color: var(--ts-ink);
    background: #fff;
    border: 1px solid #d8e0eb;
    border-radius: 9px;
    box-shadow: none;
    transition: border-color .15s ease;
  }

  .demo-page .demo-control::placeholder {
    color: #9aa8ba;
  }

  .demo-page .demo-control:hover {
    border-color: #aebeda;
  }

  .demo-page .demo-control:focus {
    border-color: var(--ts-blue);
    outline-offset: 0;
  }

  .demo-page select.demo-control {
    padding-right: 30px;
  }

  .demo-password-wrap {
    position: relative;
  }

  .demo-password-wrap .demo-control {
    padding-right: 48px;
  }

  .show-password {
    position: absolute;
    right: 6px;
    top: 4px;
    width: 37px;
    height: 36px;
    border: 0;
    border-radius: 7px;
    background: transparent;
    color: #7c8ba0;
    cursor: pointer;
  }

  .show-password:hover {
    color: var(--ts-blue);
    background: #f0f4ff;
  }

  .demo-page .demo-submit {
    width: 100%;
    min-height: 47px;
    margin-top: 24px;
    padding: 12px 18px;
    background: linear-gradient(100deg, #3174fa, #2456e8);
    border: 0;
    border-radius: 9px;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    box-shadow: 0 6px 14px rgba(36, 86, 232, .2);
    cursor: pointer;
  }

  .demo-page .demo-submit:hover:not(:disabled) {
    background: var(--ts-blue-dark);
  }

  .demo-page .demo-submit:disabled {
    opacity: .7;
    cursor: wait;
  }

  .demo-existing {
    margin: 23px 0 0;
    text-align: center;
    color: var(--ts-muted);
    font-size: 13px;
  }

  .demo-existing a {
    color: var(--ts-blue);
    font-weight: 700;
    text-decoration: none;
  }

  .demo-existing a:hover {
    text-decoration: underline;
  }

  .demo-flash {
    margin-bottom: 20px;
  }

  .demo-page .modal-content {
    border-radius: 16px;
    border: 1px solid var(--ts-line);
    box-shadow: 0 16px 50px rgba(18, 39, 79, .15);
  }

  .demo-page .modal-header {
    border-bottom: 1px solid var(--ts-line);
    padding: 22px 24px 15px;
  }

  .demo-page .modal-title {
    font-weight: 750;
    color: var(--ts-ink);
  }

  .demo-page .modal-body {
    padding: 23px 24px;
    color: #40516a;
  }

  .demo-page .modal-body li {
    margin: 0 0 9px;
  }

  .demo-page .modal-footer {
    border-top: 1px solid var(--ts-line);
  }

  .demo-page .modal-footer .btn {
    background: var(--ts-blue);
    color: white;
    border-radius: 8px;
  }

  @media (max-width: 900px) {
    .demo-main {
      grid-template-columns: 1fr;
      max-width: 660px;
      padding-top: 36px;
      gap: 38px;
    }

    .demo-story {
      padding-top: 0;
    }

    .demo-story-lead {
      margin-bottom: 30px;
    }

    .demo-form-card {
      grid-row: 1;
    }
  }

  @media (max-width: 520px) {

    .demo-header-inner,
    .demo-main {
      width: calc(100% - 30px);
    }

    .demo-header-inner {
      min-height: 67px;
    }

    .demo-brand img {
      width: 38px;
      height: 38px;
    }

    .demo-brand-name {
      font-size: 18px;
    }

    .demo-lang-label {
      display: none;
    }

    .demo-main {
      padding: 25px 0 48px;
    }

    .demo-form-card {
      padding: 28px 20px 25px;
      border-radius: 15px;
    }

    .demo-form-card h2 {
      font-size: 23px;
    }

    .demo-fields {
      grid-template-columns: 1fr;
      gap: 15px;
    }

    .demo-story h1 {
      font-size: 32px;
      letter-spacing: -1.1px;
    }

    .demo-module-grid {
      gap: 10px;
    }

    .demo-module {
      padding: 17px 15px;
      min-height: 155px;
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .demo-module {
      transition: none;
    }
  }

  /* La quinta tarjeta ocupa el ancho de las dos columnas */
  .demo-module-grid>.demo-module:last-child:nth-child(odd) {
    grid-column: 1 / -1;
    min-height: 120px;
  }

  /* Secciones del modal Comunicación */
  .demo-feature-group+.demo-feature-group {
    border-top: 1px solid var(--ts-line);
    padding-top: 18px;
    margin-top: 18px;
  }

  .demo-feature-heading {
    font-size: 15px;
    font-weight: 750;
    color: var(--ts-ink);
    margin-bottom: 12px;
  }
  </style>
</head>

<body class="demo-page">
  <header class="demo-header">
    <div class="demo-header-inner">
      <a href="<?php echo htmlspecialchars(base_url(), ENT_QUOTES, 'UTF-8'); ?>" class="demo-brand"
        aria-label="TalentSafe">
        <img src="<?php echo htmlspecialchars(base_url('img/portal_icon.png'), ENT_QUOTES, 'UTF-8'); ?>" alt=""
          aria-hidden="true">
        <span class="demo-brand-name">TalentSafe<span class="reg">®</span></span>
      </a>
      <div class="demo-lang-wrap">
        <i class="fas fa-globe" aria-hidden="true"></i>
        <label for="demo-language" class="demo-lang-label"
          data-i18n="languageLabel"><?php echo $t('languageLabel'); ?></label>
        <select id="demo-language" class="demo-language" aria-label="Language / Idioma">
          <option value="es" <?php echo $lang === 'es' ? 'selected' : ''; ?>>ES</option>
          <option value="en" <?php echo $lang === 'en' ? 'selected' : ''; ?>>EN</option>
        </select>
      </div>
    </div>
  </header>

  <main class="demo-main">
    <section class="demo-story" aria-labelledby="demo-hero-title">
      <p class="demo-eyebrow" data-i18n="eyebrow"><?php echo $t('eyebrow'); ?></p>
      <h1 id="demo-hero-title" data-i18n="heroTitle"><?php echo $t('heroTitle'); ?></h1>
      <p class="demo-story-lead" data-i18n="heroDescription"><?php echo $t('heroDescription'); ?></p>

      <section aria-labelledby="demo-modules-title">
        <h2 id="demo-modules-title" class="demo-module-heading" data-i18n="modulesTitle">
          <?php echo $t('modulesTitle'); ?></h2>
        <p class="demo-module-intro" data-i18n="modulesDescription"><?php echo $t('modulesDescription'); ?></p>
        <div class="demo-module-grid">
          <?php foreach ($modules as $module): ?>
          <button type="button" class="demo-module" data-toggle="modal" data-target="#<?php echo $module['id']; ?>">
            <span class="demo-module-icon"><i class="fas <?php echo $module['icon']; ?>" aria-hidden="true"></i></span>
            <span class="demo-module-title"
              data-i18n="<?php echo $module['title']; ?>"><?php echo $t($module['title']); ?></span>
            <span class="demo-module-desc"
              data-i18n="<?php echo $module['description']; ?>"><?php echo $t($module['description']); ?></span>
          </button>
          <?php endforeach; ?>
        </div>
      </section>
    </section>

    <section class="demo-form-card" aria-labelledby="demo-form-title">
      <p class="demo-form-eyebrow" data-i18n="formEyebrow"><?php echo $t('formEyebrow'); ?></p>
      <h2 id="demo-form-title" data-i18n="formTitle"><?php echo $t('formTitle'); ?></h2>
      <p class="demo-form-intro" data-i18n="formDescription"><?php echo $t('formDescription'); ?></p>

      <?php $flashMensaje = $this->session->flashdata('mensaje'); ?>
      <?php if ($flashMensaje): ?>
      <div class="alert alert-success demo-flash" role="status">
        <?php echo htmlspecialchars($flashMensaje, ENT_QUOTES, 'UTF-8'); ?></div>
      <?php endif; ?>

      <form id="registro-form"
        action="<?php echo htmlspecialchars(base_url('login/enviarFormulario'), ENT_QUOTES, 'UTF-8'); ?>" method="POST">
        <div class="demo-fields">
          <div class="demo-field">
            <label for="nombre" data-i18n="nameLabel"><?php echo $t('nameLabel'); ?></label>
            <input class="demo-control" type="text" name="nombre" id="nombre" autocomplete="name"
              data-i18n-placeholder="namePlaceholder" placeholder="<?php echo $t('namePlaceholder'); ?>" required>
          </div>
          <div class="demo-field">
            <label for="telefono" data-i18n="phoneLabel"><?php echo $t('phoneLabel'); ?></label>
            <input class="demo-control" type="tel" name="telefono" id="telefono" inputmode="tel" autocomplete="tel"
              data-i18n-placeholder="phonePlaceholder" placeholder="<?php echo $t('phonePlaceholder'); ?>" required>
          </div>
          <div class="demo-field demo-field-wide">
            <label for="correo" data-i18n="emailLabel"><?php echo $t('emailLabel'); ?></label>
            <input class="demo-control" type="email" name="correo" id="correo" autocomplete="email"
              data-i18n-placeholder="emailPlaceholder" placeholder="<?php echo $t('emailPlaceholder'); ?>" required>
          </div>
          <div class="demo-field demo-field-wide">
            <label for="medio_llegada" data-i18n="sourceLabel"><?php echo $t('sourceLabel'); ?></label>
            <select class="demo-control" name="medio_llegada" id="medio_llegada" required>
              <option value="" data-i18n="sourcePlaceholder"><?php echo $t('sourcePlaceholder'); ?></option>
              <option value="Google" data-i18n="sourceGoogle"><?php echo $t('sourceGoogle'); ?></option>
              <option value="Redes Sociales" data-i18n="sourceSocial"><?php echo $t('sourceSocial'); ?></option>
              <option value="Recomendación" data-i18n="sourceReferral"><?php echo $t('sourceReferral'); ?></option>
              <option value="Otro" data-i18n="sourceOther"><?php echo $t('sourceOther'); ?></option>
            </select>
          </div>
          <div class="demo-field demo-field-wide" id="campo_otro" hidden>
            <label for="descripcion_otro" data-i18n="otherLabel"><?php echo $t('otherLabel'); ?></label>
            <input class="demo-control" type="text" name="descripcion_otro" id="descripcion_otro"
              data-i18n-placeholder="otherPlaceholder" placeholder="<?php echo $t('otherPlaceholder'); ?>">
          </div>
          <div class="demo-field demo-field-wide">
            <label for="contrasena" data-i18n="passwordLabel"><?php echo $t('passwordLabel'); ?></label>
            <div class="demo-password-wrap">
              <input class="demo-control" type="password" name="contrasena" id="contrasena" autocomplete="new-password"
                data-i18n-placeholder="passwordPlaceholder" placeholder="<?php echo $t('passwordPlaceholder'); ?>"
                required>
              <button type="button" id="toggle-password" class="show-password" aria-pressed="false"
                aria-label="<?php echo $t('showPassword'); ?>" title="<?php echo $t('showPassword'); ?>">
                <i class="fas fa-eye" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
        <button type="submit" id="demo-submit" class="demo-submit"
          data-i18n="submit"><?php echo $t('submit'); ?></button>
        <p class="demo-existing">
          <span data-i18n="registeredQuestion"><?php echo $t('registeredQuestion'); ?></span>
          <a href="<?php echo htmlspecialchars(base_url('Login/index1'), ENT_QUOTES, 'UTF-8'); ?>"
            data-i18n="loginLink"><?php echo $t('loginLink'); ?></a>
        </p>
      </form>
    </section>
  </main>

  <?php foreach ($modules as $module): ?>
  <div class="modal fade" id="<?php echo $module['id']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="<?php echo $module['id']; ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title h5" id="<?php echo $module['id']; ?>Label" data-i18n="<?php echo $module['title']; ?>">
            <?php echo $t($module['title']); ?></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $t('close'); ?>"
            data-i18n-aria="close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <?php if (! empty($module['groups'])): ?>

          <?php foreach ($module['groups'] as $group): ?>
          <section class="demo-feature-group">

            <h4 class="demo-feature-heading" data-i18n="<?php echo $group['title']; ?>">
              <?php echo $t($group['title']); ?>
            </h4>

            <ul>
              <?php foreach ($group['features'] as $feature): ?>
              <li data-i18n="<?php echo $feature; ?>">
                <?php echo $t($feature); ?>
              </li>
              <?php endforeach; ?>
            </ul>

          </section>
          <?php endforeach; ?>

          <?php else: ?>

          <p>
            <strong data-i18n="featuresLabel">
              <?php echo $t('featuresLabel'); ?>
            </strong>
          </p>

          <ul>
            <?php foreach ($module['features'] as $feature): ?>
            <li data-i18n="<?php echo $feature; ?>">
              <?php echo $t($feature); ?>
            </li>
            <?php endforeach; ?>
          </ul>

          <?php endif; ?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal" data-i18n="close"><?php echo $t('close'); ?></button>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  (function() {
    'use strict';
    var translations =
      <?php echo json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var selectedLanguage = <?php echo json_encode($lang); ?>;
    var languageSelect = document.getElementById('demo-language');
    var form = document.getElementById('registro-form');
    var submitButton = document.getElementById('demo-submit');
    var sourceField = document.getElementById('medio_llegada');
    var otherField = document.getElementById('campo_otro');
    var otherInput = document.getElementById('descripcion_otro');
    var passwordInput = document.getElementById('contrasena');
    var togglePasswordButton = document.getElementById('toggle-password');
    var isSubmitting = false;

    function tr(key) {
      return (translations[selectedLanguage] || translations.es)[key] || key;
    }

    function applyLanguage(language, updateUrl) {
      if (!translations[language]) {
        language = 'en';
      }
      selectedLanguage = language;
      document.documentElement.lang = language;
      languageSelect.value = language;
      document.title = tr('pageTitle');

      document.querySelectorAll('[data-i18n]').forEach(function(element) {
        element.textContent = tr(element.getAttribute('data-i18n'));
      });
      document.querySelectorAll('[data-i18n-placeholder]').forEach(function(element) {
        element.placeholder = tr(element.getAttribute('data-i18n-placeholder'));
      });
      document.querySelectorAll('[data-i18n-aria]').forEach(function(element) {
        element.setAttribute('aria-label', tr(element.getAttribute('data-i18n-aria')));
      });
      updatePasswordButton();
      if (isSubmitting) {
        submitButton.textContent = tr('sending');
      }


      if (updateUrl && window.history && window.history.replaceState) {
        var url = new URL(window.location.href);
        url.searchParams.set('lang', language);
        window.history.replaceState(window.history.state, '', url.toString());
      }
    }

    function toggleOther() {
      var showOther = sourceField.value === 'Otro';
      otherField.hidden = !showOther;
      otherInput.required = showOther;
      if (!showOther) {
        otherInput.value = '';
      }
    }

    function updatePasswordButton() {
      var visible = passwordInput.type === 'text';
      var label = tr(visible ? 'hidePassword' : 'showPassword');
      togglePasswordButton.setAttribute('aria-label', label);
      togglePasswordButton.setAttribute('title', label);
      togglePasswordButton.setAttribute('aria-pressed', visible ? 'true' : 'false');
      togglePasswordButton.querySelector('i').className = 'fas ' + (visible ? 'fa-eye-slash' : 'fa-eye');
    }

    // El parámetro de URL tiene prioridad sobre la preferencia guardada.
    var urlLanguage = new URLSearchParams(window.location.search).get('lang');
    applyLanguage(translations[urlLanguage] ? urlLanguage : 'en', false);

    languageSelect.addEventListener('change', function() {
      applyLanguage(this.value, true);
    });
    sourceField.addEventListener('change', toggleOther);
    toggleOther();
    togglePasswordButton.addEventListener('click', function() {
      passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
      updatePasswordButton();
    });

    // Se preserva la ruta, el método POST y los nombres de campos originales.
    $('#registro-form').on('submit', function(event) {
      event.preventDefault();
      if (isSubmitting || !form.reportValidity()) {
        return;
      }
      isSubmitting = true;
      submitButton.disabled = true;
      submitButton.textContent = tr('sending');

      $.ajax({
        url: form.action,
        type: form.method,
        data: $(form).serialize(),
        dataType: 'json',
        success: function(response) {
          if (Number(response && response.codigo) === 1) {
            Swal.fire({
              icon: 'success',
              title: tr('successTitle'),
              text: response.msg || tr('successFallback'),
              confirmButtonText: tr('successConfirm')
            }).then(function() {
              form.reset();
              toggleOther();
              window.location.href = <?php echo json_encode(base_url('Login/index1')); ?>;
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: tr('errorTitle'),
              text: (response && response.msg) || tr('errorFallback'),
              confirmButtonText: tr('errorConfirm')
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: tr('errorTitle'),
            text: tr('errorGeneric'),
            confirmButtonText: tr('errorConfirm')
          });
        },
        complete: function() {
          isSubmitting = false;
          submitButton.disabled = false;
          submitButton.textContent = tr('submit');
        }
      });
    });
  })();
  </script>
</body>

</html>
<div class="container-fluid">
  <h2><?php echo $this->lang->line('mod_clients_title'); ?></h2>
  <div>
    <p><?php echo $this->lang->line('mod_intro_pre'); ?></p>
  </div>
  <table id="processTable" class="display" style="width: 100%;">
    <thead>
      <tr>
        <th style="text-align: center">
          <?php echo $this->lang->line('mod_table_branch'); ?>
        </th>
        <th style="text-align: center">
          <?php echo $this->lang->line('mod_table_email'); ?>
        </th>
        <th style="text-align: center">
          <?php echo $this->lang->line('mod_table_users_access'); ?>
        </th>
        <th style="text-align: center">
          <?php echo $this->lang->line('mod_table_candidates'); ?>
        </th>
        <th style="text-align: center">
          <?php echo $this->lang->line('mod_table_actions'); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($permisos) && ! empty($permisos)): ?>
      <?php foreach ($permisos as $p): ?>
      <?php if (isset($p['nombreCliente']) && isset($p['url'])): ?>
      <tr>
        <td><?php echo htmlspecialchars($p['nombreCliente'], ENT_QUOTES, 'UTF-8'); ?></td>

        <td>
          <?php echo isset($p['correo'])
                        ? htmlspecialchars($p['correo'], ENT_QUOTES, 'UTF-8')
                    : $this->lang->line('mod_table_na'); ?>
        </td>

        <td>
          <ul class="usuarios-acceso-list">
            <?php foreach ($p['usuarios'] as $usuario): ?>
            <li class="usuario-acceso-item">
              <div class="usuario-info">
                <span class="usuario-nombre">
                  <?php echo htmlspecialchars($usuario['nombre_completo'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
                <span class="usuario-detalle">
                  <?php echo htmlspecialchars($usuario['rol'], ENT_QUOTES, 'UTF-8'); ?>
                  · ID:<?php echo htmlspecialchars($usuario['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
              </div>

              <?php
            $idRol = $this->session->userdata('idrol');
            if ($idRol == 6 || $idRol == 1):
        ?>
              <button type="button" class="btn-usuario-remove eliminar-permiso"
                data-id_usuario="<?php echo $usuario['id_usuario']; ?>"
                data-id_cliente="<?php echo $p['id_cliente']; ?>" title="Eliminar acceso a esta sucursal/cliente">
                <i class="fa fa-trash"></i>
              </button>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </td>


        <td>
          <?php echo $this->lang->line('mod_table_candidates_prefix'); ?>
          <?php echo isset($p['pre_empleados'])
                        ? htmlspecialchars($p['pre_empleados'], ENT_QUOTES, 'UTF-8')
                    : $this->lang->line('mod_table_na'); ?>
        </td>

        <td>
          <a href="<?php echo site_url(htmlspecialchars($p['url'], ENT_QUOTES, 'UTF-8')); ?>" class="btn-ver-empleados">
            <?php echo $this->lang->line('mod_btn_view_process'); ?>
          </a>
        </td>
      </tr>
      <?php endif; ?>
      <?php endforeach; ?>
      <?php else: ?>
      <tr>
        <td colspan="5">
          <?php echo $this->lang->line('mod_table_no_branches'); ?>
        </td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<style>
.modulo-titulo {
  font-size: 28px;
  font-weight: bold;
  color: #9fda64;
  /* Verde claro */
  margin-bottom: 10px;
}

#processTable thead {
  background: linear-gradient(to right, #9fda64, #7eb94f) !important;
  /* Degradado verde */
  color: white;
  text-align: center;
}

#processTable th,
#processTable td {
  vertical-align: top;
  text-align: left;
  padding: 10px;
}

#processTable tbody tr:hover {
  background-color: #f3fbec;
  /* Verde muy claro para hover */
}

.btn-ver-empleados,
.pre-employment-btn {
  background: linear-gradient(to right, #9fda64, #7eb94f);
  /* Botón con degradado verde */
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 6px;
  font-weight: bold;
  text-decoration: none;
  display: inline-block;
  transition: background 0.3s ease;
}

.btn-ver-empleados:hover,
.pre-employment-btn:hover {
  background: linear-gradient(45deg, #8ecf55, #6ca93c);
  /* Hover más intenso */
}
.usuarios-acceso-list {
  list-style: none;
  margin: 0;
  padding-left: 0;
}

/* Tarjetita por usuario */
.usuario-acceso-item {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 8px;
  background: #f7ffe9; /* verde muy clarito */
  border-radius: 6px;
  padding: 6px 10px;
  margin-bottom: 6px;
  border: 1px solid rgba(159, 218, 100, 0.35);
}

.usuario-info {
  display: flex;
  flex-direction: column;
}

.usuario-nombre {
  font-weight: 600;
  font-size: 0.9rem;
  color: #333;
}

.usuario-detalle {
  font-size: 0.78rem;
  color: #666;
}

/* Botón de eliminar a la derecha */
.btn-usuario-remove {
  background: transparent;
  border: none;
  color: #e74c3c;
  cursor: pointer;
  padding: 0;
  line-height: 1;
}

.btn-usuario-remove i {
  font-size: 1rem;
}

.btn-usuario-remove:hover i {
  transform: scale(1.1);
}

</style>

<script>
$(document).ready(function() {
  $('#processTable').DataTable({
    order: [] // respeta el orden del foreach del servidor
  });

  $('#sidebarToggle').on('click', function() {
    $('#sidebar').toggleClass('hidden');
  });
});

// === Textos de SweetAlert traídos desde modulos_lang ===
const PERM_TXT = {
  confirmTitle: '<?php echo $this->lang->line('mod_perm_delete_title'); ?>',
  confirmText: '<?php echo $this->lang->line('mod_perm_delete_text'); ?>',
  confirmOk: '<?php echo $this->lang->line('mod_perm_delete_confirm'); ?>',
  confirmCancel: '<?php echo $this->lang->line('mod_perm_delete_cancel'); ?>',
  deletedTitle: '<?php echo $this->lang->line('mod_perm_deleted_title'); ?>',
  deletedText: '<?php echo $this->lang->line('mod_perm_deleted_text'); ?>',
  errorTitle: '<?php echo $this->lang->line('mod_perm_error_title'); ?>',
  errorDelete: '<?php echo $this->lang->line('mod_perm_error_delete'); ?>'
};

// === Borrado de permiso (igual que en exempleados) ===
$(document).on('click', '.eliminar-permiso', function(e) {
  e.preventDefault();

  var id_usuario = $(this).data('id_usuario');
  var id_cliente = $(this).data('id_cliente');

  Swal.fire({
    title: PERM_TXT.confirmTitle,
    text: PERM_TXT.confirmText,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: PERM_TXT.confirmOk,
    cancelButtonText: PERM_TXT.confirmCancel,
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '<?php echo site_url("Cat_UsuarioInternos/eliminarPermiso"); ?>',
        method: 'POST',
        data: {
          id_usuario: id_usuario,
          id_cliente: id_cliente
        },
        success: function(response) {
          var data = JSON.parse(response);
          if (data.status === 'success') {
            Swal.fire(
              PERM_TXT.deletedTitle,
              PERM_TXT.deletedText,
              'success'
            );
            location.reload();
          } else {
            Swal.fire(
              PERM_TXT.errorTitle,
              data.message || PERM_TXT.errorDelete,
              'error'
            );
          }
        },
        error: function() {
          Swal.fire(
            PERM_TXT.errorTitle,
            PERM_TXT.errorDelete,
            'error'
          );
        }
      });
    }
  });
});
</script>
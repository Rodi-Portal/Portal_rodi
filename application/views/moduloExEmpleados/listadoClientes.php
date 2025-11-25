<div class="container-fluid">
  <h2><?php echo $this->lang->line('mod_exempleados_title'); ?></h2>

  <p><?php echo $this->lang->line('mod_intro_exempleados'); ?></p>

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
          <?php echo $this->lang->line('mod_table_access_branch'); ?>
        </th>
        <th style="text-align: center">
          <?php echo $this->lang->line('mod_table_employees'); ?>
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
          <li>
            <?php echo $this->lang->line('mod_ex_max_number'); ?>
            <?php echo htmlspecialchars($p['max'], ENT_QUOTES, 'UTF-8'); ?>
          </li>
          <li>
            <?php echo $this->lang->line('mod_ex_employees_active'); ?>
            <?php echo htmlspecialchars($p['empleados_activos'], ENT_QUOTES, 'UTF-8'); ?>
          </li>
          <li>
            <?php echo $this->lang->line('mod_ex_employees_inactive'); ?>
            <?php echo htmlspecialchars($p['empleados_inactivos'], ENT_QUOTES, 'UTF-8'); ?>
          </li>
        </td>

        <td>
          <a href="<?php echo site_url('procesoFormer/' . $p['id_cliente']); ?>" class="btn-ver-empleados">
            <?php echo $this->lang->line('mod_btn_view_exemployees'); ?>
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
  color: #58c4f5;
  /* Cambiado a azul claro */
  margin-bottom: 10px;
}

#processTable thead {
  background: linear-gradient(to right, #58c4f5, #31a5d3) !important;
  /* Azul degradado */
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
  background-color: #e8f7fe;
  /* Azul muy claro para hover */
}

.btn-ver-empleados,
.former-employment-btn {
  background: linear-gradient(to right, #58c4f5, #31a5d3);
  /* Botón azul con degradado */
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
.former-employment-btn:hover {
  background: linear-gradient(45deg, #2fa6cf, #007ca8);
  /* Efecto hover más intenso */
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
  background: #cae7f2ff;
  /* verde muy clarito */
  border-radius: 6px;
  padding: 6px 10px;
  margin-bottom: 6px;
  border: 1px solid rgba(134, 215, 243, 0.57);
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
    order: [], // respeta el orden del foreach
  });

  $('#sidebarToggle').on('click', function() {
    $('#sidebar').toggleClass('hidden');
  });
});

// === Textos de SweetAlert traídos desde CI_LANG ===
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
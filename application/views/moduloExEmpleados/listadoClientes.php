
<div class="container-fluid">
<h2>Former Employees Module</h2>
    <p>Select a user to view the  employees associated with that profile.</p>
    <table id="processTable" class="display" style="width: 100%;">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Email</th>
                <th>Phone</th>
                
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($permisos) && !empty($permisos)): ?>
                <?php foreach ($permisos as $p): ?>
                    <?php if (isset($p->nombreCliente) && isset($p->url)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p->nombreCliente, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo isset($p->correo) ? htmlspecialchars($p->correo, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
                            <td><?php echo isset($p->telefono) ? htmlspecialchars($p->telefono, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
                            <td><?php echo isset($p->creacion) ? htmlspecialchars($p->creacion, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
                            <td>
                            <a href="<?php echo site_url('procesoFormer/' . $p->id_cliente); ?>" class="btn btn-primary">View Former  Employees</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No clients registered yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
    .container-fluid {
        width: 100%; /* Full width */
        padding: 20px; /* Internal padding */
        box-sizing: border-box; /* Include padding in width */
    }

    #processTable {
        width: 100%; /* Make the table full width */
        border-collapse: collapse; /* Ensure borders collapse */
    }

    #processTable th, #processTable td {
        border: 1px solid #ddd; /* Add borders to table cells */
        padding: 8px; /* Add padding inside cells */
        text-align: left; /* Align text to the left */
    }

    #processTable th {
        background-color: #f2f2f2; /* Header background color */
        font-weight: bold; /* Bold header text */
    }
</style>

<script>
    $(document).ready(function() {
        $('#processTable').DataTable();
        $('#sidebarToggle').on('click', function() {
            $('#sidebar').toggleClass('hidden'); // Alternar la clase 'hidden'
        });
    });
    
</script>
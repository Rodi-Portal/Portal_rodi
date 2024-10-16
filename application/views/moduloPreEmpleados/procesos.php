<div class="container-fluid">
    <h2>Pre-Employment</h2>
    <p>Here you will see the list of your clients or branches.</p>
    <table id="processTable" class="display" style="width: 100%;">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
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
                            <td><?php echo isset($p->email) ? htmlspecialchars($p->email, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
                            <td><?php echo isset($p->phone) ? htmlspecialchars($p->phone, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
                            <td><?php echo isset($p->status) ? htmlspecialchars($p->status, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
                            <td><?php echo isset($p->createdDate) ? htmlspecialchars($p->createdDate, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
                            <td>
                                <a href="<?php echo site_url(htmlspecialchars($p->url, ENT_QUOTES, 'UTF-8')); ?>" class="btn btn-primary">View Process</a>
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

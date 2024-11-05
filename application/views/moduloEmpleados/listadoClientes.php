<div class="container-fluid">
    <h2>Employees Module</h2>
    <p>
    Select a user to view the  employees associated with that profile.</p>
    
    <input type="text" id="searchInput" placeholder="Search by name, email, or phone" class="search-input">
    
    <div class="card-container" id="cardContainer">
        <?php if (isset($permisos) && !empty($permisos)): ?>
            <?php foreach ($permisos as $p): ?>
                <?php if (isset($p->nombreCliente) && isset($p->url)): ?>
                    <div class="card" data-name="<?php echo htmlspecialchars($p->nombreCliente, ENT_QUOTES, 'UTF-8'); ?>" 
                                 data-email="<?php echo isset($p->correo) ? htmlspecialchars($p->correo, ENT_QUOTES, 'UTF-8') : 'N/A'; ?>" 
                                 data-phone="<?php echo isset($p->telefono) ? htmlspecialchars($p->telefono, ENT_QUOTES, 'UTF-8') : 'N/A'; ?>">
                        <div class="card-header">
                            <h3><?php echo htmlspecialchars($p->nombreCliente, ENT_QUOTES, 'UTF-8'); ?></h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Email:</strong> <?php echo isset($p->correo) ? htmlspecialchars($p->correo, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></p>
                            <p><strong>Phone:</strong> <?php echo isset($p->telefono) ? htmlspecialchars($p->telefono, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></p>
                            <p><strong>Created Date:</strong> <?php echo isset($p->creacion) ? htmlspecialchars($p->creacion, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></p>
                        </div>
                        <div class="card-footer">
                        <a href="<?php echo site_url('proceso/' . $p->id_cliente); ?>" class="btn btn-primary">View Employees</a>

                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-clients">
                <p>No clients registered yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .container-fluid {
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .search-input {
        width: 100%; /* Ancho completo */
        padding: 10px; /* Espaciado interno */
        margin-bottom: 20px; /* Espacio debajo */
        border: 1px solid #ccc; /* Borde */
        border-radius: 5px; /* Bordes redondeados */
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Espacio entre tarjetas */
        justify-content: space-between; /* Alinear las tarjetas en filas */
    }

    .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: calc(30% - 20px); /* Ancho de las tarjetas */
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .card-header {
        padding: 15px;
        background-color: #f2f2f2;
    }

    .card-body {
        padding: 15px;
        flex: 1;
    }

    .card-footer {
        padding: 15px;
        background-color: #f9f9f9;
        text-align: right;
    }

    .no-clients {
        text-align: center;
        width: 100%;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const cardContainer = document.getElementById('cardContainer');
        const cards = cardContainer.getElementsByClassName('card');

        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();

            Array.from(cards).forEach(card => {
                const name = card.getAttribute('data-name').toLowerCase();
                const email = card.getAttribute('data-email').toLowerCase();
                const phone = card.getAttribute('data-phone').toLowerCase();

                if (name.includes(filter) || email.includes(filter) || phone.includes(filter)) {
                    card.style.display = ''; // Mostrar tarjeta
                } else {
                    card.style.display = 'none'; // Ocultar tarjeta
                }
            });
        });

        // Eliminar el código de DataTable si no se necesita
        $('#sidebarToggle').on('click', function() {
            $('#sidebar').toggleClass('hidden');
        });
    });
</script>
<div class="container">
    <h1>Twoje Konto</h1>
    <div class="card card-body">
        <ul class="list-unstyled">
            <li class="nav-item">
                <a class="nav-link" href="/konto/wiadomosci">Wiadomości</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/konto/opinie">Twoje opinie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/konto/dane">Edytuj dane</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/konto/haslo">Edytuj Hasło</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/konto/zgody">Edytuj zgody</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/konto/usun">Usuń konto</a>
            </li>
        </ul>
    </div>
    <?php if($user->data): ?>
    <img src="<?php echo $user->data->image ?>" alt="<?php echo $user->data->name ?>">
    <?php endif; ?>
</div>
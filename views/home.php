<div class="content">
    <div class="container">
        <header>
            <div id="logo">
                <a href="/"><?php echo $this->image('logo.png') ?></a>
            </div>
        </header>
        <main>
            <div id="main-text">
                <div class="title">
                    <h1>Dieta, trening, catering - wybierz wszystko <span>w jednym miejscu</span></h1>
                </div>
                <div id="main-search">
                    <div class="search-inner">
                        <label>Czego szukasz?</label>
                        <div class="input-group">
                            <input type="text" name="search" placeholder="np. dieta, dietetyk, plan treningowy, catering...">
                            <div class="dropdown">
                                <div class="dropdown-toggle" type="button" id="searchDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Cała polska <i class="far fa-chevron-down"></i>
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="searchDropdown">
                                    <li><a class="dropdown-item" href="#">Pół polski</a></li>
                                    <li><a class="dropdown-item" href="#">Ćwiartka polski</a></li>
                                </ul>
                            </div>
                        </div>
                        <button type="submit" class="green-gradient-button">Szukaj</button>
                    </div>
                    <div class="additional-options">
                        <button>Dodatkowe opcje wyszukiwania <i class="far fa-plus-circle"></i></button>
                    </div>
                </div>
                <div class="home-info-text">
                    <p>Skorzystaj z wyszukiwarki lub dodaj ogłoszenie aby otrzymać specjalne oferty</p>
                </div>
                <div id="main-boxes">
                    <div class="box">
                        <i class="fal fa-plus-circle"></i>
                        <p>Dodaj <span>darmowe ogłoszenie</span></p>
                    </div>
                    <div class="box">
                        <i class="fal fa-users"></i>
                        <p>Sprawdź <span>zgłoszenia specjalistów</span></p>
                    </div>
                    <div class="box">
                        <i class="fal fa-user-check"></i>
                        <p>Wybierz <span>osoby do współpracy</span></p>
                    </div>
                </div>
                <div class="how-it-works-link">
                    <a href="#"><i class="far fa-play"></i> Zobacz jak to działa</a>
                </div>
            </div>
            <div id="home-form-wrapper">
                <div class="inner">
                    <div class="home-form-top">
                        <form action="/rejestracja" method="POST" id="register-form" class="home-form" autocomplete="off">
                            <div class="head">
                                <h3>Załóż konto</h3>
                                <p>Dodaj ogłoszenie, wybierz specjalistów i poczekaj na oferty</p>
                            </div>
                            <div class="input">
                                <input type="text" name="name" required autocomplete="new-password">
                                <label><i class="far fa-user"></i>Imię...</label>
                            </div>
                            <div class="input">
                                <input type="text" name="email" required autocomplete="new-password">
                                <label><i class="far fa-at"></i>Adres e-mail...</label>
                            </div>
                            <div class="input">
                                <input type="password" name="password" required autocomplete="new-password">
                                <label><i class="far fa-lock"></i>Hasło...</label>
                            </div>
                            <button class="submit-button login-button" type="submit" class="orange-gradient-button">Przejdź dalej</button>
                        </form>
                        <form action="/login" method="POST" id="login-form" class="hidden home-form">
                            <div class="head">
                                <h3>Zaloguj się</h3>
                                <p>Dodaj ogłoszenie, wybierz specjalistów i poczekaj na oferty</p>
                            </div>
                            <div class="input">
                                <input type="text" name="email" required autocomplete="new-password">
                                <label><i class="far fa-at"></i>Adres e-mail...</label>
                            </div>
                            <div class="input">
                                <input type="password" name="password" required autocomplete="new-password">
                                <label><i class="far fa-lock"></i>Hasło...</label>
                            </div>
                            <button class="submit-button login-button" type="submit" class="orange-gradient-button">Zaloguj</button>
                        </form>
                    </div>
                    <div class="home-form-bottom">
                        <div class="form-link">
                            <p>Masz już konto? <a href="#login-form">Zaloguj się</a></p>
                        </div>
                        <div class="form-link hidden">
                            <p>Nie masz jeszcze konta? <a href="#login-form">Zarejestruj się</a></p>
                        </div>
                        <button class="login-button" id="facebook-login"><?php echo $this->image('facebook.png', 'Facebook') ?>Zaloguj przez Facebooka</button>
                        <button class="login-button" id="google-login"><?php echo $this->image('google.png', 'Google') ?>Zaloguj przez Google</button>
                        <div class="home-form-text">
                            <p>Przechodząc dalej, wyrażasz zgodę na następujące zasady <a href="#">Warunki korzystania z serwisu</a>, <a href="#">politykę prywatności</a> oraz <a href="#">politkę cookies</a></p>
                        </div>
                    </div>
                </div>
                <div class="home-form-partner">
                    <p>Chcesz zostać pratnerem? <a href="#">Sprawdź szczegóły</a></p>
                </div>
            </div>
        </main>
    </div>
</div>

<footer id="home-footer">
    <div class="menu">
        <div class="container">
            <ul>
                <li><a href="#">Logowanie</a></li>
                <li><a href="#">Rejestracja</a></li>
                <li><a href="#" class="active">Dla firm</a></li>
                <li><a href="#">Warunki korzystania</a></li>
                <li><a href="#">Polityka cookies</a></li>
            </ul>
        </div>
    </div>
    <div class="fot">
        <div class="container">
            <div class="inner">
                <p class="copy">Wszelkie prawa zastrzeżone &copy; <?php echo date('Y') ?> loremipsum.pl</p>
                <p class="exio">Realizacja <a href="#">exio</a></p>
            </div>
        </div>
    </div>
</footer>
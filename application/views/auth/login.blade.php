<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Activisme | Login</title>
        <link rel="stylesheet" href="{{ base_url('assets/css/header.css') }}"/>
        <link rel="stylesheet" href="{{ base_url('assets/css/footer.css') }}"/>
        <link rel="stylesheet" href="{{ base_url('assets/css/connection.css') }}"/>
    </head>
    <body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ base_url() }}">Home</a></li>
                <li><a href="{{ base_url('authencation/login') }}">Log-in</a></li>
                <li><a href="{{ base_url('authencation/register') }}">Register</a></li>
                <li><a href="mailto:info@activisme.be">Contact</a></li>
            </ul>
        </nav>
        <section>
            <h1>ACTIVISME_BE</h1>
            <h3>TOM MANHAEGHE</h3>
        </section>
    </header>
    <main>
        <form method="POST" action="{{ base_url('authencation/verify') }}">
            <h1>Login</h1>

            {{ validation_errors() }}

            <section>
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" placeholder="E-mail"/>
            </section>
            <section>
                <label for="paswoord">Wachtwoord:</label>
                <input type="password" id="password" name="password" placeholder="Password"/>
            </section>
            <section>
                <label for="submit">Registreer</label>
                <input type="submit" id="submit" value="Registreer"/>
            </section>
        </form>
    </main>
    <footer>
        <section>
            <h1>Information</h1>
            <section>
                <h2>Share</h2>
                <nav>
                    <ul>
                        <li><a href="http://www.facebook.com/share.php?u=http://www.activisme.be&title=activisme.be">FACEBOOK</a></li>
                        <li><a href="http://twitter.com/intent/tweet?status=activisme.be+http://www.activisme.be">TWITTER</a></li>
                        <li><a href="http://www.activisme.be">LINKEDIN</a></li>
                        <li><a href="https://plus.google.com/share?url=http://www.activisme.be">GOOGLEPLUS</a></li>
                    </ul>
                </nav>
            </section>

            <section>
                <h2>Follow</h2>
                <nav>
                    <ul>
                        <li><a href="https://www.facebook.com/ActivismeBE/" target="blank">FB ACTIVISME</a></li>
                        <li><a href="https://twitter.com/Activisme_be" target="blank">TWITTER ACTIVISME</a></li>
                        <li><a href="https://www.facebook.com/tom.manhaeghe.game" target="blank">FB TOM MANHAEGHE</a></li>
                        <li><a href="https://twitter.com/manhaeghe" target="blank">TWITTER TOM MANHAEGHE</a></li>
                        <li><a href="https://www.flickr.com/photos/activisme/" target="blank">FLICKR</a></li>
                        <li><a href="https://www.youtube.com/channel/UCVL0CgcRZu8fgCKad5Mi9WA" target="blank">YOUTUBE</a></li>
                    </ul>
                </nav>
            </section>

            <section>
                <h2>Links</h2>
                <nav>
                    <ul>
                        <li><a href="http://www.intal.be/" target="blank">INTAL</a></li>
                        <li><a href="https://www.vrede.be/" target="blank">VREDE.BE</a></li>
                        <li><a href="https://www.vredesactie.be/" target="blank">VREDESACTIE.BE</a></li>
                        <li><a href="http://www.hartbovenhard.be/" target="blank">HART BOVEN HARD</a></li>
                        <li><a href="http://www.solidarityforall.be" target="blank">SOLIDARITY FOR ALL</a></li>
                        <li><a href="https://www.amnesty-international.be" target="blank">AMNESTY INTERNATIONAL</a></li>
                    </ul>
                </nav>
            </section>
        </section>
        <p><strong>Copyright &copy; activisme_be 2016</strong></p>
    </footer>
    </body>
</html>

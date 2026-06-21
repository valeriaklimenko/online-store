<footer class="klavera-footer">
    <div class="klavera-shell">
        <div class="klavera-footer__logo">Klavera</div>

        <div class="klavera-footer__grid">
            <div class="klavera-footer__col">
                <h3>Shop</h3>
                <ul>
                    <li><a href="{{ route('home', ['new_collection' => 1]) }}#products">New arrivals</a></li>
                    <li><a href="{{ route('home') }}#products">Shop all</a></li>
                </ul>
            </div>
            <div class="klavera-footer__col">
                <h3>Discover</h3>
                <ul>
                    <li><a href="{{ route('home') }}#products">Catalog</a></li>
                </ul>
            </div>
            <div class="klavera-footer__col">
                <h3>Help</h3>
                <ul>
                    <li><a href="#">Shipping &amp; returns</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="klavera-footer__col">
                <h3>Connect</h3>
                <ul>
                    <li><a href="#">Instagram</a></li>
                </ul>
            </div>
            <div class="klavera-footer__col">
                <h3>Newsletter</h3>
                <form class="klavera-footer__newsletter" action="#" method="post" onsubmit="return false;">
                    <input type="email" name="email" placeholder="your email" aria-label="Email">
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="klavera-footer__bottom">
            <span>&copy; {{ date('Y') }} Klavera</span>
            <a href="#">Terms of service</a>
            <a href="#">Privacy policy</a>
        </div>
    </div>
</footer>

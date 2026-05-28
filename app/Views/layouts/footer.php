    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <p class="footer-copyright">
                &copy; <?= date('Y') ?> <strong>YakroStyle</strong> – Vêtements de qualité à Yamoussoukro
            </p>
            <p class="footer-links">
                <a href="/produits">Boutique</a> |
                <a href="/panier">Panier</a> |
                <?php if (session()->get('user_id')): ?>
                    <a href="/deconnexion">Déconnexion</a>
                <?php else: ?>
                    <a href="/connexion">Connexion</a> |
                    <a href="/inscription">Inscription</a>
                <?php endif; ?>
                <?php if (session()->get('user_role') === 'admin'): ?>
                    | <a href="/admin">Administration</a>
                <?php endif; ?>
            </p>
            <p class="footer-contact">
                📞 Service client : <a href="tel:+2250788642814">07 88 642 814</a>
                <br>Ou
                <a href="https://wa.me/2250788642814" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: #25D366">
                    <i class="fab fa-whatsapp"></i> Contactez-nous sur WhatsApp
                </a>
                <br>
                <a href="mailto:assidjo1@gmail.com">assidjo1@gmail.com</a>
            </p>
        </div>
    </footer>

    <script src="/js/app.js"></script>
</body>
</html>
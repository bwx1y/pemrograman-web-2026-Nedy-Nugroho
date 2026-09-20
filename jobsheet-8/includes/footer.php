        <footer class="footer">
            <p>&copy; 2026 Goods Office &mdash; Jobsheet 7</p>
        </footer>
    </main>
</div>

<script src="<?php echo $base; ?>assets/js/app.js"></script>
<?php if (!empty($extra_scripts)): foreach ($extra_scripts as $src): ?>
<script src="<?php echo $src; ?>"></script>
<?php endforeach;
endif; ?>
</body>
</html>

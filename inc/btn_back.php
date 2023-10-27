<p class="has-text-right">
	<a href="#" class="button is-link is-rounded btn-back"><- Regresar </a>
</p>

<script type="text/javascript">
    let btn_back = document.querySelector(".btn-back");

    btn_back.addEventListener('click', function(e){
        e.preventDefault();
        window.history.back();
    });
</script>
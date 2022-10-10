 <script src="<?= base_url('public/assets/library/bootstrap-5.2.2/js/bootstrap.bundle.min.js') ?>"></script>
 <script src="<?= base_url('public/assets/library/jquery-3.6.1.min.js') ?>"></script>
 <script src="<?= base_url('public/assets/library/notiflix-aio-3.2.5.min.js') ?>"></script>

 <script>
     Notiflix.Notify.init({
         borderRadius: "0px",
         showOnlyTheLastOne: true,
         position: "center-top",
         cssAnimationStyle: "from-top"
     })

     Notiflix.Loading.init({
         svgColor: '#0d6efd',
     });
 </script>
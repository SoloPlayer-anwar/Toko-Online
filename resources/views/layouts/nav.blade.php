<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

    {{-- PENDAFTARAN --}}

      <li class="nav-item menu-open">
        <a href="#" class="nav-link active">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Kumpulan Data User
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('user.index')}}" class="nav-link">
              <i class="far fa-user nav-icon"></i>
              <p>User</p>
            </a>
          </li>
        </ul>

        <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('category.index')}}" class="nav-link">
                <i class="fas fa-sitemap nav-icon"></i>
                <p>Kategori Product</p>
              </a>
            </li>
        </ul>

        <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('product.index')}}" class="nav-link">
                <i class="fas fa-list nav-icon"></i>
                <p>Product</p>
              </a>
            </li>
        </ul>

        <ul class="nav nav-treeview">
            <li class="nav-item">
                <form action="{{route('logout')}}" method="POST" id="logout">
                    @csrf
                    <a href="#" class="nav-link" onclick="document.getElementById('logout').submit()">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </form>
            </li>
        </ul>


      </li>

{{-- TUTUP PENDAFTARAN --}}




    </ul>
  </nav>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Memperbarui ikon aktif saat halaman dimuat
        updateActiveItem();

        $('.nav-item').click(function() {
            // Menghapus kelas "active" dari semua item navigasi
            $('.nav-item').removeClass('active');

            // Menambahkan kelas "active" pada item navigasi yang diklik
            $(this).addClass('active');

            // Memperbarui item navigasi aktif setelah klik
            updateActiveItem();
        });

        // Memperbarui item navigasi aktif saat halaman berubah
        $(window).on('popstate', function() {
            updateActiveItem();
        });

        function updateActiveItem() {
            // Menghapus kelas "active" dari semua item navigasi
            $('.nav-item').removeClass('active');

            // Mendapatkan URL saat ini
            var currentUrl = window.location.href;

            // Mencari tautan yang sesuai dengan URL saat ini
            $('.nav-item a').each(function() {
                var linkUrl = $(this).attr('href');
                if (currentUrl.indexOf(linkUrl) > -1) {
                    $(this).closest('.nav-item').addClass('active');
                    return false; // Berhenti mencari setelah menemukan tautan yang cocok
                }
            });
        }
    });
</script>

<style>
    .nav-item.active a {
        color: green; /* Ganti dengan warna hijau yang Anda inginkan */
    }
</style>

Mustache.tags = ['{%', '%}'];

$(function(){
    // Mengubah data pada input type hidden ke dalam javascript array.
    var save_json = JSON.parse($('#save_json').val());

    // Fungsi render digunakan untuk merender data dan template mustache ke dalam elemen yg sudah ditentukan
    function render()
    {
        // Memanggil fungsi getIndex sebelum ditampilkan
        getIndex();
        // Mengubah list array ke dalam bentuk data json lalu dimasukan ke dalam input type hidden
        $('#save_json').val(JSON.stringify(save_json));

        // Mendefinisikan template
        var tmpl = $('#add_item').html();
        // parse template ke dalam mustache template
        Mustache.parse(tmpl);
        // Merender dengan template dan data
        // variable 'item' adalah variable yang akan dilooping
        var html = Mustache.render(tmpl, { item : save_json });
        // mengisi html tbody dengan hasil renderan di atas
        $('#render').html(html);
        /*});*/

        // memanggil fungsi bind
        bind();
    }

    // PENTING. fungsi bind digunakan untuk memberikan event listener kepada elemen html setelah render selesai. Jika tidak dilakukan bind maka event pada elemen tidak akan berjalan.
    function bind(){
        // Memberikan event listener pada tombol pada saat tombol diklik
        $('#AddItem').on('click', add);
        $('.btn-delete-item').on('click', delete_item);
        $('.btn-edit-item').on('click', edit);
        $('.btn-cancel-item').on('click', canceledit);
        $('.btn-save-item').on('click', saveedit);
    }


    // Fungsi add untuk menambah item ke dalam list
    function add()
    {
        // Membaca nilai dari inputan
        var penyakit = $('#penyakit').val();

        // if (kode_pasien == '') {
        //      alert('Silahkan Input Nama');
        //      return false;
        // }else if (penyakit == '') {
        //     alert('Harga Not Valid');
        //      return false;
        //     alert('Silahkan Input Jumlah');
        // }else if (quantity == '') {
        //      return false;
        // }else if (isNaN(quantity)) {
        //     alert('Jumlah Not Valid');
        //      return false;
        // }

        // Membuat object yg akan dimasukan kedalam array
        var input = {
            'penyakit' : penyakit,
        };


        // Memasukan object ke dalam array
        save_json.push(input);

        // Merender ulang karena data sudah berubah

        render();

    }

    // fungsi edit untuk menampilkan form edit
    function edit()
    {
        // Mengambil id item yang akan dihapus
        var i = parseInt($(this).data('id'), 10);

        var row_data = $("#data_" + i);
        var row_form = $("#form_" + i);
        var input_data = $("#input_data");

        // menyembunyikan input form
        if(!input_data.hasClass('hidden')){
            input_data.addClass('hidden');
        }

        // menyembunyikan baris data
        if(!row_data.hasClass('hidden')){
            row_data.addClass('hidden');
        }

        // menampilkan baris form
        if(row_form.hasClass('hidden')){
            row_form.removeClass('hidden');
        }
    }

    // fungsi edit untuk menyembunyikan form edit
    function canceledit()
    {
        render();
    }

    function saveedit()
    {
        // Mengambil id item yang akan dihapus
        var i = parseInt($(this).data('id'), 10);

        // Membaca nilai dari inputan
        var penyakit = $('#penyakit_' + i).val();

        // Menyimpan data pada list
        save_json[i].penyakit = penyakit;

        // Merender kembali karena data sudah berubah
        render();
    }

    // Fungsi delete_phone digunakan untuk menghapus elemen
    function delete_item(){
        // Mengambil id item yang akan dihapus
        var i = parseInt($(this).data('id'), 10);

        // menghapus list dari elemen array
        save_json.splice(i, 1);

        // Merender kembali karena data sudah berubah
        render();
    }

    // Fungsi getIndex digunakan untuk membuat penomoran dan id unik sebelum dirender
    function getIndex()
    {
        for (idx in save_json) {
            // setting _id digunakan untuk memudahkan dalam mengedit dan menghapus list, seperti id pada tabel dalam database.
            save_json[idx]['_id'] = idx;
            // setting no digunakan untuk penomoran
            save_json[idx]['no'] = parseInt(idx) + 1;
        }
    }

    // Memanggil fungsi render pada saat halaman pertama kali dimuat
    render();
});

/**
 * Angka ajaib adalah angka bulat positif yang jumlah akhir 
 * dari penjumlahan kuadrat tiap bilangannya = 1
 *
 */
function ajaib(str) {

	// Cek input apakah input adalah angka
	var angka = parseInt(str);

	/**
	 * Fungsi untuk penjumlahan angka ajaib
	 * Jumlahkan angka dan cek apakah hasil akhirnya adalah 1
	 * Jika 1 maka angka adalah ajaib.
	 *
	 * @params int angka
	 *
	 */
	var jumlahkan = function( angka ){

		// Rubah input kedalam array
		var angkaArr = angka.toString().split('');

		var hasil = 0;
		angkaArr.forEach(function(angkaTunggal){
			hasil += Math.pow( parseInt(angkaTunggal), 2);
		});
		if ( hasil == 1 )
			return true;
		else 
			return jumlahkan(hasil);
	}

	// Jumlahkan angka
	return jumlahkan(angka);
};


/**
 * Diberikan pola dan string str, tentukan apakah string cocok dengan pola-nya.
 * Contoh: 
 *   pola = "abba", str = "ayam goreng goreng ayam" return true.
 *   pola = "abba", str = "ayam goreng goreng lunak" return false.
 *
 */
function pola_ok(pola, str) {

	// Buat pola dan string kedalam array
	var polaArr = pola.split('');
	var strArr = str.split(' ');

	// Jika pola dan string panjangnya tidak sama maka false 
	if ( polaArr.length != strArr.length )
		return false;

	/**
	 * Fungsi untuk cek apakah karakter itu vokal atau konsonan
	 * @params str karakter
	 *
	 */
	var hurufVokal = function(karakter){
		// Untuk performa script, cek huruf voal tidak menggunakan regex
		return karakter === 'a' || karakter === 'e' || karakter === 'i' || karakter === 'o' || karakter === 'u' || false;
	}

	for (idx = 0; idx < polaArr.length; ++idx){
		if ( hurufVokal(polaArr[idx]) != hurufVokal( strArr[idx].substr(0,1) ) ){
			return false;
		}
	}

	return true;
};



/**
 * Diberikan string yang hanya menggunakan karakter '(', ')', '{', '}', '[' dan ']', tentukan kesempurnaan kurungannya.
 * Kurungan dianggap sempurna apabila menutup dengan urutan yang benar, 
 * contoh: "()" dan "()[]{}" adalah sempurna, sedangkan "(]" dan "([)]" adalah tidak sempurna, seperti kita...manusia.
 * format yang benar dan akan return true:
 * 1. Karakter kurung pembuka dan penutup di sebelahnya, 
 *    contoh: ()[]{}
 * 2. Karakter kurung pembuka dan penutup di akhir
 *    contoh: ([{[()]}])
 *
 */
function sampoerna(str) {
	var karakterPembuka = [ '{', '[', '(' ];
	var karakterPenutup = [ '}', ']', ')' ];

	var strLength = str.length;
	var result = true;

	// Cek setiap karakter pada string input yang diberikan
	for (var i = 0; i < strLength; i++) {

		/**
		 * Temukan index dari karakter pembuka
		 * 0: {
		 * 1: [
		 * 2: (
		 *
		 */
		karakterIdx = karakterPembuka.indexOf( str[i] );
		if ( karakterIdx < 0 ){
			/**
			 * Return false jika pada karakter pertama 
			 * tidak ditemukan karakter pembuka
			 *
			 */
			return false;
		} else {

			/**
			 * Jika index karakter pembuka sama dengan 
			 * index karakter penutup satu pasang maka lanjutkan pengecekan
			 * satu pasang itu contoh nya: {}/[]/()
			 *
			 */
			if ( karakterPenutup.indexOf( str[i +1] ) == karakterIdx ){
				i++;


			/**
			 * Jika tidak ditemukan karakter pasangan penutup pada karakter selanjutnya,
			 * Dicoba mungkin penutup karakter berada pada akhir kalimat
			 * Format yang dicari adalah: {[()]} 
			 *
			 */
			} else if ( karakterPenutup.indexOf( str[ str.length - (i +1) ] ) == karakterIdx ){
				strLength--;


			/** 
			 * False tidak ditemukan pasangan yang cocok
			 * Tidak ditemukan dengan format ()[]{} ataupun ({[]})
			 *
			 */
			} else {
				return false;
			}
		}
	}
	return result;
};


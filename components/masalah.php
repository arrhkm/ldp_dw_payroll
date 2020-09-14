masalah Libur nasional dan libur hari minggu biasa 

1. hari minggu 
- Kondisi Overtime : 
    * T masakerja ada
- Tidak Overtime : 
    * 
 2. Jika Hari Libur Nasional 
 - kondisi OT 
   * GP Ada 
   * TJ Masakerja 
- tdk overtime 
    * GP Saja 
    
masalah : jika pasa hari minggu dan pasa hari nasional , maka yang dipilih yang mana ?




sep 2 2020
--------------


1. Menambahkan Menu edit waktu perpanjangan karyawan dirumahkan (javascript selectet column)
2. Pembulatan Angka Salary All Karyawan --> (OK)
3. Kekurangan dan Kelebihan 
4. Potongan BPJS 
5. Keterangan keperluan Kasbonan
6. Kasbon yang sudah di close ikut tertutup di payroll nya seharusnya masih tampil. -->(ok)
7. Update Leave error Undefined variable: emp_list -->(ok)
8. Jika tidak ada absensi (in = null out = null), seharusnya keterangan muncul (ok)
9. Pesan error untuk Kasbon yang melebihi saldo pemotongan belum ada. 
//----------------------------------------------------------
Tanggal 3 sep 2020
//---------------------------
- perbaiki pC pak Agus QC 

10.Tidak ada absensi, seharusnya gaji nilai nya nol.
11. Penggajian orang yang sakit lama : 
    - 4 bulan sejak sakit = 100%;
    - 4 bulan ke2 = 75%;
    - 4 bulan ke3 = 50%
    -  bulan ke4 = 25%;
    -           = 0% = metu ;
12. Jika ada lembur tandai warna merah. 
13. Mesin absensi Integration sudah di input in jam 03:59 MULYANTO namun data masih tetep dibaca tdk ada in nya. (OK)
//------------------------------------------------------
Tanggal 4 sep 2020
--------------------------------------------------------
- perbaikan js getSelectedRow()
---------------------------------------------------------
Tanggal 7 Sept 2020
---------------------------------------------------------
Java script getslected row error 
- perbaikan PC Pak Agus Budiono 

tanggal 10 Sept 2020
------------------------
- add user terpotong bpjs 
- Import Csv potongan dirumahkan
- membenahi potongan covid dirumahkan 


tanggal 11 sept 2020
-----------------------------
- menambahkan summary payrolll sebelum di archive untuk controll admin costproject -->OK
- add Import CSV pada instentif Ketinggian dll.
- potongan telat P129 tgl 08-09-2020 telat 9 menit tidaka masuk potongan 
- Calculasi Cuti tidak masuk hitungan (gaji Basic).
----------------------------------------------------------------------------------------------
- Timeshift seharusnya mengandung atrribute (id_employee, id_period, id_payroll_group) supaya 
   bisa menghitung periode gajian putus di tengah.
----------------------------------------------------------------------------------------------
- insentif inputan nya kalenadar nya harus banyak item (multiple tanggal) / orang nilainya.
- Khusus Insentif Cucui mobil nilainya berdasarkan nilai 1 jam dari basicsalary. 
- Kasbon harus ada List kasbon master untuk schedul pemotongan gaji karyawan (tenor kasbon tidak bisa diupdate setelah kesepakatan , hanya nilainya yang bisa diupdate).

-- ada di no 11. Penggajian orang yang sakit lama ? SAKIT KERAS : 
    - 4 bulan sejak sakit = 100%;
    - 4 bulan ke2 = 75%;
    - 4 bulan ke3 = 50%
    -  bulan ke4 = 25%;
    -           = 0% = metu ;

- Tandai Kuning untuk jam Overtime (request FARIS) -->OK
- Jika Kontrak masih PKWT, maka masakerja = 0 -->OK (FENDI hari kamis absen nya null).
- 

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return redirect('/login');
    // return view('auth.login');
});

Route::get('/nip-patch',function(){
	$employees = App\Model\Reference\Employee::get();
	foreach ($employees as $employee) {
		$user = App\User::find($employee->user_id);
		$user->NIP = $employee->NIP;
		$user->save();
	}
});


Route::middleware('auth')->group(function(){
	Route::get('notification-redirector/{notification}','HomeController@notificationRedirector')->name('notification-redirector');
	Route::get('file-viewer','HomeController@fileViewer')->name('file-viewer');
	Route::get('profil','HomeController@profil')->name('profil');
	Route::get('edit-profil','HomeController@editProfil')->name('edit-profil');
	Route::put('update-profil','HomeController@updateProfil')->name('update-profil');
	Route::post('update-avatar','HomeController@updateAvatar')->name('update-avatar');
	// Route::get('agenda','HomeController@agenda')->name('agenda');
	Route::middleware('admin')->group(function(){
		Route::prefix('reference')->namespace('Reference')->group(function(){
			Route::prefix('golongan')->group(function(){
				Route::get('/','GolonganController@index')->name('reference.golongan.index');
				Route::get('create','GolonganController@create')->name('reference.golongan.create');
				Route::get('edit/{golongan}','GolonganController@edit')->name('reference.golongan.edit');
				Route::post('insert','GolonganController@store')->name('reference.golongan.insert');
				Route::put('update','GolonganController@update')->name('reference.golongan.update');
				Route::delete('delete','GolonganController@destroy')->name('reference.golongan.delete');
			});

			Route::prefix('eselon')->group(function(){
				Route::get('/','EselonController@index')->name('reference.eselon.index');
				Route::get('create','EselonController@create')->name('reference.eselon.create');
				Route::get('edit/{eselon}','EselonController@edit')->name('reference.eselon.edit');
				Route::post('insert','EselonController@store')->name('reference.eselon.insert');
				Route::put('update','EselonController@update')->name('reference.eselon.update');
				Route::delete('delete','EselonController@destroy')->name('reference.eselon.delete');
			});

			Route::prefix('employee')->group(function(){
				Route::get('/','EmployeeController@index')->name('reference.employee.index');
				Route::get('create','EmployeeController@create')->name('reference.employee.create');
				Route::get('edit/{employee}','EmployeeController@edit')->name('reference.employee.edit');
				Route::get('show/{employee}','EmployeeController@show')->name('reference.employee.show');
				Route::post('insert','EmployeeController@store')->name('reference.employee.insert');
				Route::put('update','EmployeeController@update')->name('reference.employee.update');
				Route::delete('delete','EmployeeController@destroy')->name('reference.employee.delete');
			});

			Route::prefix('group')->group(function(){
				Route::get('/','GroupController@index')->name('reference.group.index');
				Route::get('create','GroupController@create')->name('reference.group.create');
				Route::get('edit/{group}','GroupController@edit')->name('reference.group.edit');
				Route::get('show/{group}','GroupController@show')->name('reference.group.show');
				Route::post('insert','GroupController@store')->name('reference.group.insert');
				Route::put('update','GroupController@update')->name('reference.group.update');
				Route::delete('delete','GroupController@destroy')->name('reference.group.delete');

				Route::get('show/{group}/create','SubGroupController@create')->name('reference.group.sub.create');
				Route::get('show/{group}/edit/{sub}','SubGroupController@edit')->name('reference.group.sub.edit');
				Route::get('show/{group}/staff/{sub}','SubGroupController@show')->name('reference.group.sub.show');
				Route::post('show/{group}/insert','SubGroupController@store')->name('reference.group.sub.insert');
				Route::put('show/{group}/update','SubGroupController@update')->name('reference.group.sub.update');
				Route::delete('show/{group}/delete','SubGroupController@destroy')->name('reference.group.sub.delete');

				Route::get('show/{group}/staff/{sub}/create','SubGroupStaffController@create')->name('reference.group.sub.staff.create');
				Route::post('show/{group}/staff/{sub}/insert','SubGroupStaffController@store')->name('reference.group.sub.staff.insert');
				Route::delete('show/{group}/staff/{sub}/delete','SubGroupStaffController@destroy')->name('reference.group.sub.staff.delete');
			});

			// Route::prefix('program')->group(function(){
			// 	Route::get('/','ProgramController@index')->name('reference.program.index');
			// 	Route::get('create','ProgramController@create')->name('reference.program.create');
			// 	Route::get('edit/{program}','ProgramController@edit')->name('reference.program.edit');
			// 	Route::post('insert','ProgramController@store')->name('reference.program.insert');
			// 	Route::put('update','ProgramController@update')->name('reference.program.update');
			// 	Route::delete('delete','ProgramController@destroy')->name('reference.program.delete');
			// });

			// Route::prefix('kegiatan')->group(function(){
			// 	Route::get('/','KegiatanController@index')->name('reference.kegiatan.index');
			// 	Route::get('create','KegiatanController@create')->name('reference.kegiatan.create');
			// 	Route::get('edit/{kegiatan}','KegiatanController@edit')->name('reference.kegiatan.edit');
			// 	Route::post('insert','KegiatanController@store')->name('reference.kegiatan.insert');
			// 	Route::put('update','KegiatanController@update')->name('reference.kegiatan.update');
			// 	Route::delete('delete','KegiatanController@destroy')->name('reference.kegiatan.delete');
			// });

			Route::prefix('rekening')->group(function(){
				Route::get('/','RekeningController@index')->name('reference.rekening.index');
				Route::get('create','RekeningController@create')->name('reference.rekening.create');
				Route::get('edit/{rekening}','RekeningController@edit')->name('reference.rekening.edit');
				Route::post('insert','RekeningController@store')->name('reference.rekening.insert');
				Route::put('update','RekeningController@update')->name('reference.rekening.update');
				Route::delete('delete','RekeningController@destroy')->name('reference.rekening.delete');
			});

			Route::prefix('wilayah')->group(function(){
				Route::get('/','WilayahController@index')->name('reference.wilayah.index');
				Route::get('create','WilayahController@create')->name('reference.wilayah.create');
				Route::get('edit/{wilayah}','WilayahController@edit')->name('reference.wilayah.edit');
				Route::post('insert','WilayahController@store')->name('reference.wilayah.insert');
				Route::put('update','WilayahController@update')->name('reference.wilayah.update');
				Route::delete('delete','WilayahController@destroy')->name('reference.wilayah.delete');
			});

			Route::prefix('transportation')->group(function(){
				Route::get('/','TransportationController@index')->name('reference.transportasi.index');
				Route::get('create','TransportationController@create')->name('reference.transportasi.create');
				Route::get('edit/{transportation}','TransportationController@edit')->name('reference.transportasi.edit');
				Route::post('insert','TransportationController@store')->name('reference.transportasi.insert');
				Route::put('update','TransportationController@update')->name('reference.transportasi.update');
				Route::delete('delete','TransportationController@destroy')->name('reference.transportasi.delete');
			});
		});

		Route::prefix('users')->group(function(){
			Route::get('/','UserController@index')->name('users.index');
			Route::get('create','UserController@create')->name('users.create');
			Route::get('edit/{user}','UserController@edit')->name('users.edit');
			Route::post('insert','UserController@store')->name('users.insert');
			Route::put('update','UserController@update')->name('users.update');
			Route::delete('delete','UserController@destroy')->name('users.delete');
		});

		Route::prefix('setting')->group(function(){
			Route::get('/','SettingController@index')->name('setting.index');
			Route::put('update','SettingController@update')->name('setting.update');
			Route::post('upload','SettingController@upload')->name('setting.upload');
		});
	});

	Route::prefix('program')->namespace('Reference')->group(function(){
		Route::get('/','ProgramController@index')->name('reference.program.index');
		Route::get('create','ProgramController@create')->name('reference.program.create');
		Route::get('edit/{program}','ProgramController@edit')->name('reference.program.edit');
		Route::post('insert','ProgramController@store')->name('reference.program.insert');
		Route::put('update','ProgramController@update')->name('reference.program.update');
		Route::delete('delete','ProgramController@destroy')->name('reference.program.delete');
	});

	Route::prefix('kegiatan')->namespace('Reference')->group(function(){
		Route::get('/','KegiatanController@index')->name('reference.kegiatan.index');
		Route::get('create','KegiatanController@create')->name('reference.kegiatan.create');
		Route::get('edit/{kegiatan}','KegiatanController@edit')->name('reference.kegiatan.edit');
		Route::post('insert','KegiatanController@store')->name('reference.kegiatan.insert');
		Route::put('update','KegiatanController@update')->name('reference.kegiatan.update');
		Route::delete('delete','KegiatanController@destroy')->name('reference.kegiatan.delete');
	});

	Route::middleware('pegawai')->group(function(){

		Route::prefix('agenda')->group(function(){
			Route::get('/','AgendaController@index')->name('agenda.index');
			Route::get('create','AgendaController@create')->name('agenda.create');
			Route::get('edit/{agenda}','AgendaController@edit')->name('agenda.edit');
			Route::get('show/{agenda}','AgendaController@show')->name('agenda.show');
			Route::get('acc/{agenda}','AgendaController@acc')->name('agenda.acc');
			Route::get('tolak/{agenda}','AgendaController@tolak')->name('agenda.tolak');
			Route::post('insert','AgendaController@store')->name('agenda.insert');
			Route::put('update','AgendaController@update')->name('agenda.update');
			Route::delete('delete','AgendaController@destroy')->name('agenda.delete');
		});

		Route::prefix('surat-keluar')->group(function(){
			Route::get('/','SuratKeluarController@index')->name('pegawai.surat-keluar.index');
			Route::get('create','SuratKeluarController@create')->name('pegawai.surat-keluar.create');
			Route::get('edit/{surat}','SuratKeluarController@edit')->name('pegawai.surat-keluar.edit');
			Route::get('show/{surat}','SuratKeluarController@show')->name('pegawai.surat-keluar.show');
			Route::post('insert','SuratKeluarController@store')->name('pegawai.surat-keluar.insert');
			Route::post('accept','SuratKeluarController@accept')->name('pegawai.surat-keluar.accept');
			Route::post('decline','SuratKeluarController@decline')->name('pegawai.surat-keluar.decline');
			Route::post('arsip','SuratKeluarController@arsip')->name('pegawai.surat-keluar.arsip');
			Route::post('set-agenda','SuratKeluarController@setAgendaSurat')->name('pegawai.surat-keluar.set-agenda');
			Route::put('update','SuratKeluarController@update')->name('pegawai.surat-keluar.update');
			Route::delete('delete','SuratKeluarController@destroy')->name('pegawai.surat-keluar.delete');
		});

		Route::prefix('spt')->group(function(){
			Route::get('/','SptController@index')->name('pegawai.spt.index');
			Route::get('rekapitulasi','SptController@rekapitulasi')->name('pegawai.spt.rekapitulasi');
			Route::get('create','SptController@create')->name('pegawai.spt.create');
			Route::get('edit/{spt}','SptController@edit')->name('pegawai.spt.edit');
			Route::get('show/{spt}','SptController@show')->name('pegawai.spt.show');
			Route::get('cetak/{spt}','SptController@cetak')->name('pegawai.spt.cetak');
			Route::post('insert','SptController@store')->name('pegawai.spt.insert');
			Route::put('update','SptController@update')->name('pegawai.spt.update');
			Route::put('doupdate','SptController@doupdate')->name('pegawai.spt.doupdate');
			Route::post('accept','SptController@accept')->name('pegawai.spt.accept');
			Route::post('arsip','SptController@arsip')->name('pegawai.spt.arsip');
			Route::post('upload','SptController@upload')->name('pegawai.spt.upload');
			Route::post('decline','SptController@decline')->name('pegawai.spt.decline');
			Route::post('get-employees','SptController@getEmployees')->name('pegawai.spt.get-employees');
			Route::post('set-urutan','SptController@setUrutan')->name('pegawai.spt.set-urutan');
			Route::delete('delete','SptController@destroy')->name('pegawai.spt.delete');
		});

		Route::prefix('sppd')->group(function(){
			Route::get('/','SppdController@index')->name('pegawai.sppd.index');
			Route::get('rekapitulasi','SppdController@rekapitulasi')->name('pegawai.sppd.rekapitulasi');
			Route::get('create','SppdController@create')->name('pegawai.sppd.create');
			Route::get('edit/{sppd}','SppdController@edit')->name('pegawai.sppd.edit');
			Route::get('show/{sppd}','SppdController@show')->name('pegawai.sppd.show');
			Route::get('cetak/{sppd}','SppdController@cetak')->name('pegawai.sppd.cetak');
			Route::get('detail-biaya/{sppd}','SppdController@detailBiaya')->name('pegawai.sppd.detail-biaya');
			Route::get('cetak-rincian/{sppd}','SppdController@cetakRincian')->name('pegawai.sppd.cetak-rincian');
			Route::post('insert','SppdController@store')->name('pegawai.sppd.insert');
			Route::post('get-employee','SppdController@getEmployees')->name('pegawai.sppd.get-employees');
			Route::post('set-urutan','SppdController@setUrutan')->name('pegawai.sppd.set-urutan');
			Route::post('set-maskapai','SppdController@setMaskapai')->name('pegawai.sppd.set-maskapai');
			Route::post('set-biaya','SppdController@setBiaya')->name('pegawai.sppd.set-biaya');
			Route::put('update','SppdController@update')->name('pegawai.sppd.update');
			Route::delete('delete','SppdController@destroy')->name('pegawai.sppd.delete');
		});

		Route::middleware('specialRoleUser')->group(function(){
			Route::prefix('surat-masuk')->namespace('SpecialRole')->group(function(){
				Route::get('/','SuratMasukController@index')->name('pegawai.surat-masuk.index');
				Route::get('create','SuratMasukController@create')->name('pegawai.surat-masuk.create');
				Route::get('edit/{surat}','SuratMasukController@edit')->name('pegawai.surat-masuk.edit');
				Route::get('show/{surat}','SuratMasukController@show')->name('pegawai.surat-masuk.show');
				Route::get('print/{surat}','SuratMasukController@print')->name('pegawai.surat-masuk.print');
				Route::post('arsip','SuratMasukController@arsip')->name('pegawai.surat-masuk.arsip');
				Route::post('insert','SuratMasukController@store')->name('pegawai.surat-masuk.insert');
				Route::post('teruskan','SuratMasukController@teruskan')->name('pegawai.surat-masuk.teruskan');
				Route::put('update','SuratMasukController@update')->name('pegawai.surat-masuk.update');
				Route::delete('delete','SuratMasukController@destroy')->name('pegawai.surat-masuk.delete');
			});

			Route::prefix('spt-role')->namespace('SpecialRole')->group(function(){
				Route::get('/','SptController@index')->name('pegawai.spt-role.index');
				Route::get('create','SptController@create')->name('pegawai.spt-role.create');
				Route::get('edit/{spt}','SptController@edit')->name('pegawai.spt-role.edit');
				Route::get('show/{spt}','SptController@show')->name('pegawai.spt-role.show');
				Route::get('cetak/{spt}','SptController@cetak')->name('pegawai.spt-role.cetak');
				Route::get('rekapitulasi','SptController@rekapitulasi')->name('pegawai.spt-role.rekapitulasi');
				Route::post('insert','SptController@store')->name('pegawai.spt-role.insert');
				Route::post('arsip','SptController@arsip')->name('pegawai.spt-role.arsip');
				Route::post('set-no-spt','SptController@setNoSpt')->name('pegawai.spt-role.set-no-spt');
				Route::post('get-employees','SptController@getEmployees')->name('pegawai.spt-role.get-employees');
				Route::post('set-urutan','SptController@setUrutan')->name('pegawai.spt-role.set-urutan');
				Route::put('update','SptController@update')->name('pegawai.spt-role.update');
				Route::delete('delete','SptController@destroy')->name('pegawai.spt-role.delete');
			});

			Route::prefix('sppd-role')->group(function(){
				Route::get('/','SptController@index')->name('pegawai.sppd-role.index');
				Route::get('show/{sppd}','SptController@show')->name('pegawai.sppd-role.show');
				Route::get('cetak/{sppd}','SptController@cetak')->name('pegawai.sppd-role.cetak');
			});

		});

		Route::middleware('pimpinan')->group(function(){
			Route::prefix('surat')->namespace('Pimpinan')->group(function(){
				Route::get('/','SuratController@index')->name('pimpinan.surat.index');
				Route::get('disposisi','SuratController@disposisi')->name('pimpinan.surat.disposisi');
				Route::get('show/{surat}','SuratController@show')->name('pimpinan.surat.show');
				Route::post('show/{surat}/set-disposisi','SuratController@setDisposisi')->name('pimpinan.surat.set-disposisi');
			});
		});

		Route::post('set-disposisi/{surat}','SpecialRole\SuratMasukController@setDisposisi')->name('sekretaris.surat.set-disposisi');

		Route::get('disposisi','HomeController@disposisi')->name('disposisi');
		Route::post('set-disposisi','HomeController@setDisposisi')->name('set-disposisi');
		Route::get('detail-surat-masuk/{surat}','HomeController@detailSuratMasuk')->name('detail-surat-masuk');
	});
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

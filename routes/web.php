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
    return view('auth.login');
});

Route::middleware('auth')->group(function(){
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

			Route::prefix('program')->group(function(){
				Route::get('/','ProgramController@index')->name('reference.program.index');
				Route::get('create','ProgramController@create')->name('reference.program.create');
				Route::get('edit/{program}','ProgramController@edit')->name('reference.program.edit');
				Route::post('insert','ProgramController@store')->name('reference.program.insert');
				Route::put('update','ProgramController@update')->name('reference.program.update');
				Route::delete('delete','ProgramController@destroy')->name('reference.program.delete');
			});

			Route::prefix('kegiatan')->group(function(){
				Route::get('/','KegiatanController@index')->name('reference.kegiatan.index');
				Route::get('create','KegiatanController@create')->name('reference.kegiatan.create');
				Route::get('edit/{kegiatan}','KegiatanController@edit')->name('reference.kegiatan.edit');
				Route::post('insert','KegiatanController@store')->name('reference.kegiatan.insert');
				Route::put('update','KegiatanController@update')->name('reference.kegiatan.update');
				Route::delete('delete','KegiatanController@destroy')->name('reference.kegiatan.delete');
			});

			Route::prefix('rekening')->group(function(){
				Route::get('/','RekeningController@index')->name('reference.rekening.index');
				Route::get('create','RekeningController@create')->name('reference.rekening.create');
				Route::get('edit/{rekening}','RekeningController@edit')->name('reference.rekening.edit');
				Route::post('insert','RekeningController@store')->name('reference.rekening.insert');
				Route::put('update','RekeningController@update')->name('reference.rekening.update');
				Route::delete('delete','RekeningController@destroy')->name('reference.rekening.delete');
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

	Route::middleware('pegawai')->group(function(){
		Route::middleware('special')->group(function(){
			Route::prefix('surat-masuk')->namespace('SpecialRole')->group(function(){
				Route::get('/','SuratMasukController@index')->name('pegawai.surat-masuk.index');
				Route::get('create','SuratMasukController@create')->name('pegawai.surat-masuk.create');
				Route::get('edit/{surat}','SuratMasukController@edit')->name('pegawai.surat-masuk.edit');
				Route::get('show/{surat}','SuratMasukController@show')->name('pegawai.surat-masuk.show');
				Route::post('insert','SuratMasukController@store')->name('pegawai.surat-masuk.insert');
				Route::put('update','SuratMasukController@update')->name('pegawai.surat-masuk.update');
				Route::delete('delete','SuratMasukController@destroy')->name('pegawai.surat-masuk.delete');
			});

			Route::prefix('surat-keluar')->namespace('SpecialRole')->group(function(){
				Route::get('/','SuratKeluarController@index')->name('pegawai.surat-keluar.index');
				Route::get('create','SuratKeluarController@create')->name('pegawai.surat-keluar.create');
				Route::get('edit/{surat}','SuratKeluarController@edit')->name('pegawai.surat-keluar.edit');
				Route::get('show/{surat}','SuratKeluarController@show')->name('pegawai.surat-keluar.show');
				Route::post('insert','SuratKeluarController@store')->name('pegawai.surat-keluar.insert');
				Route::put('update','SuratKeluarController@update')->name('pegawai.surat-keluar.update');
				Route::delete('delete','SuratKeluarController@destroy')->name('pegawai.surat-keluar.delete');
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

		Route::get('disposisi','HomeController@disposisi')->name('disposisi');
		Route::get('detail-surat-masuk/{surat}','HomeController@detailSuratMasuk')->name('detail-surat-masuk');
	});
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

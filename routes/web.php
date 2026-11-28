<?php

use App\Http\Controllers\CotizacionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página Principal
Route::get('/', function () {
    return view('home');
})->name('home');

// Páginas de Servicios Informativas
Route::get('/monitoreo-ambiental', function () {
    return view('servicios.ambiental');
})->name('servicios.ambiental');

Route::get('/monitoreo-ocupacional', function () {
    return view('servicios.ocupacional');
})->name('servicios.ocupacional');

Route::get('/venta-y-alquiler-de-equipos', function () {
    return view('servicios.equipos');
})->name('servicios.equipos');

Route::get('/alquiler-de-equipos', function () {
    return view('servicios.equipos');
});

// Páginas de Cotizaciones
// 1. Cotizar Ahora - Formulario general para todos los servicios
Route::get('/cotizar-ahora', function () {
    return view('cotizar.ahora');
})->name('cotizar.ahora');

// 2. Cotizadores Referenciales Online con Generación de PDF
Route::get('/cotiza-monitoreo-ambiental', function () {
    return view('cotizar.ambiental');
})->name('cotizar.ambiental');

Route::get('/cotiza-monitoreo-ocupacional', function () {
    return view('cotizar.ocupacional');
})->name('cotizar.ocupacional');

Route::get('/cotiza-venta-y-alquiler-de-equipos', function () {
    return view('cotizar.equipos');
})->name('cotizar.equipos');

Route::get('/cotiza-alquiler-de-equipos', function () {
    return view('cotizar.equipos');
});

// API de Envío de Cotizaciones por Correo Electrónico (notificaciones@pachabol.com)
Route::get('/api/cotizaciones/siguiente-codigo', [CotizacionController::class, 'siguienteCodigo'])->name('cotizaciones.siguiente-codigo');
Route::post('/api/cotizaciones/enviar', [CotizacionController::class, 'enviarCorreo'])->name('cotizaciones.enviar');
Route::post('/api/cotizaciones/test-email', [CotizacionController::class, 'probarSmtp'])->name('cotizaciones.test');

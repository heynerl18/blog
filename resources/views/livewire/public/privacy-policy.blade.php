@section('title', 'Política de Privacidad')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header centrado -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                Política de Privacidad
            </h1>
            <div class="w-24 h-1 bg-blue-600 mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                <strong>Última actualización:</strong> {{ now()->format('d F Y') }}
            </p>
        </div>

        <!-- Contenido en tarjeta centrada -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 md:p-12">
            <div class="prose prose-lg dark:prose-invert max-w-none">
                
                <!-- Introducción -->
                <div class="mb-10">
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-lg">
                        Tu privacidad es importante para nosotros. Esta política explica de manera transparente cómo recopilamos y protegemos tu información cuando visitas nuestro blog. Si tienes alguna pregunta, no dudes en contactarnos.
                    </p>
                </div>

                <!-- Sección 1 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">1</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Información que Recopilamos</h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                        Cuando interactúas con nuestro blog, podemos recopilar la siguiente información:
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <strong class="text-gray-800 dark:text-gray-200">Información que nos proporcionas directamente:</strong>
                                <span class="text-gray-600 dark:text-gray-300"> Por ejemplo, tu nombre y dirección de correo electrónico cuando dejas un comentario o nos contactas.</span>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <strong class="text-gray-800 dark:text-gray-200">Información técnica básica:</strong>
                                <span class="text-gray-600 dark:text-gray-300"> Tu navegador envía automáticamente información técnica básica (como dirección IP y tipo de dispositivo) que es necesaria para el funcionamiento del sitio web.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección 2 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">2</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Uso de la Información</h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                        Utilizamos la información recopilada para:
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">Gestionar y mantener el blog</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">Mejorar la experiencia del usuario</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">Responder a tus comentarios o preguntas</span>
                        </li>
                    </ul>
                </div>

                <!-- Sección 3 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">3</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Compartir Información</h2>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-r-lg mb-4">
                        <p class="text-green-800 dark:text-green-200 leading-relaxed m-0">
                            <strong>💚 Nuestra promesa:</strong> No vendemos, comercializamos ni transferimos tu información personal a terceros.
                        </p>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Podemos compartir información únicamente con los proveedores técnicos esenciales para el funcionamiento del blog, quienes están obligados contractualmente a proteger tu información.
                    </p>
                </div>

                <!-- Sección 4 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">4</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Tus Derechos</h2>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <div>
                                <p class="text-blue-800 dark:text-blue-200 font-medium mb-3">
                                    Tienes derecho a acceder, corregir o eliminar tu información personal.
                                </p>
                                <a href="{{ route('public.contact') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Ejercer mis derechos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección 5 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">5</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Cambios en esta Política</h2>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 p-4 rounded-r-lg">
                        <p class="text-amber-800 dark:text-amber-200 leading-relaxed m-0">
                            <strong>📢 Actualizaciones:</strong> Nos reservamos el derecho de actualizar esta política de privacidad. Te notificaremos sobre cualquier cambio publicando la nueva política en esta página.
                        </p>
                    </div>
                </div>

                <!-- Mensaje final amigable -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-center">
                        Al usar nuestro blog, aceptas esta política de privacidad. Si tienes alguna inquietud o no estás de acuerdo con algún punto, no dudes en contactarnos para conversarlo.
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@section('title', 'Términos y Condiciones')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header centrado -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                Términos y Condiciones
            </h1>
            <div class="w-24 h-1 bg-blue-600 mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                <strong>Última actualización:</strong> {{ now()->format('d F Y') }}
            </p>
        </div>

        <!-- Contenido en tarjeta centrada -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 md:p-12">
            <div class="prose prose-lg dark:prose-invert max-w-none">
                
                <!-- Sección 1 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">1</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Aceptación de los Términos</h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Al usar nuestro blog, aceptas estos términos y condiciones que hemos diseñado para crear una experiencia positiva para todos. Si tienes dudas o algún término no te resulta claro, no dudes en contactarnos.
                    </p>
                </div>

                <!-- Sección 2 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">2</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Contenido del Blog</h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                        Todo el contenido publicado en este blog, incluyendo textos, imágenes y videos, es propiedad de <strong>{{ config('app.name') }}</strong> y está protegido por derechos de autor. Puedes compartir nuestro contenido para uso personal y no comercial, siempre y cuando des el crédito adecuado.
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        El contenido de este blog tiene fines informativos y de entretenimiento. No nos hacemos responsables de la exactitud o la veracidad de la información publicada.
                    </p>
                </div>

                <!-- Sección 3 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">3</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Conducta del Usuario</h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                        Al utilizar nuestro blog, te comprometes a no:
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">Publicar comentarios ofensivos, difamatorios o que inciten al odio.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">Utilizar el blog para fines ilegales.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">Interrumpir el funcionamiento del sitio o la experiencia de otros usuarios.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">Infringir los derechos de propiedad intelectual de otros.</span>
                        </li>
                    </ul>
                </div>

                <!-- Sección 4 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">4</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Enlaces a Sitios de Terceros</h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Nuestro blog puede contener enlaces a sitios web de terceros. No somos responsables por el contenido o las políticas de privacidad de estos sitios. El acceso a cualquier sitio enlazado es bajo tu propio riesgo.
                    </p>
                </div>

                <!-- Sección 5 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">5</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Limitación de Responsabilidad</h2>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 p-4 rounded-r-lg">
                        <p class="text-amber-800 dark:text-amber-200 leading-relaxed m-0">
                            <strong>Importante:</strong> Este blog se proporciona "tal cual". No garantizamos que el contenido sea preciso, completo o actualizado. No seremos responsables por ningún daño directo, indirecto, incidental o consecuente derivado del uso de este blog.
                        </p>
                    </div>
                </div>

                <!-- Sección 6 -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">6</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Ley Aplicable</h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Estos términos se rigen e interpretan de acuerdo con las leyes de <strong>Costa Rica</strong>, sin dar efecto a ningún principio de conflicto de leyes.
                    </p>
                </div>

                <!-- Sección 7 - Contacto destacado -->
                <div class="mb-10">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">7</div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 m-0">Contacto</h2>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <div>
                                <p class="text-blue-800 dark:text-blue-200 font-medium mb-3">
                                    ¿Tienes preguntas sobre estos términos?
                                </p>
                                <a href="{{ route('public.contact') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Contáctanos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
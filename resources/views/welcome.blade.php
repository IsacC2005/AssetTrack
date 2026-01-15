<!DOCTYPE html>

<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="relative border-4 min-h-screen w-full bg-[#090b0b] flex flex-col items-center pt-24 px-4">
    <div
        class="absolute -left-1/2 -top-1/4 inset-0 bg-[radial-gradient(circle_at_50%_20%,_rgba(45,212,191,0.12),transparent_50%)]">
    </div>

    <div class="relative z-10 max-w-4xl text-center">
        <span
            class="px-3 py-1 text-[10px] font-bold tracking-widest text-teal-500 uppercase border border-teal-500/30 rounded-full bg-teal-500/5">
            Open Source Asset Management
        </span>

        <h1 class="mt-8 text-5xl md:text-7xl font-extrabold text-white tracking-tight">
            Diseñado para un <span class="text-teal-400">control de activos</span> de precisión.<br />
        </h1>

        <p class="mt-6 text-gray-400 text-lg max-w-2xl mx-auto leading-relaxed">
            Una interfaz administrativa de alta fidelidad desarrollada con Laravel y Filament. Gestiona la
            infraestructura con precisión quirúrgica.
        </p>

        <div class="mt-10 flex gap-4 justify-center">
            <a href="https://github.com/IsacC2005/AssetTrack" target="_blank"
                class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-500 transition-all shadow-[0_0_20px_rgba(20,184,166,0.3)]">
                Obtener código
            </a>
            <a href="/admin"
                class="px-8 py-3 bg-[#1c2324] text-gray-300 font-semibold rounded-lg border border-white/5 hover:bg-[#252d2e] transition-all">
                Realizar prueba
            </a>
        </div>
    </div>

    <div class="relative mx-auto max-w-5xl px-4 pb-24 pt-20">

        <div class="rounded-xl border border-white/10 bg-[#090b0b] shadow-2xl overflow-hidden shadow-teal-500/10">

            <div class="flex items-center gap-2 bg-[#111] px-4 py-3 border-b border-white/5">
                <div class="flex gap-1.5">
                    <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                </div>
                <div class="mx-auto bg-white/5 px-3 py-1 rounded text-[10px] text-gray-500 font-mono w-1/3 text-center">
                    filament-assets.internal/dashboard
                </div>
            </div>

            <div class="relative">
                <img src="/photos/assettrack_dashboard.png" alt="Filament Dashboard" class="w-full h-auto block">

                <div class="absolute inset-0 bg-gradient-to-t from-[#090b0b] via-transparent to-transparent opacity-40">
                </div>
            </div>
        </div>

        <div
            class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-teal-500/10 blur-[120px] rounded-full">
        </div>
    </div>
</body>

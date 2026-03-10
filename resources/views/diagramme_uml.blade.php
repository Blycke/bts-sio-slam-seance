@extends('layouts.app')

@section('title', 'Diagramme UML')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">

<div class="uml-page">
    <div class="uml-header">
        <div class="uml-title-block">
            <span class="uml-badge">UML 2.0</span>
            <h1 class="uml-title">BiblioTech — Diagramme de Classes</h1>
            <p class="uml-subtitle">Structure des modèles, relations et contrôleurs</p>
        </div>
        <div class="uml-legend">
            <div class="legend-item"><span class="legend-line solid"></span> Association</div>
            <div class="legend-item"><span class="legend-line dashed"></span> Dépendance</div>
            <div class="legend-item"><span class="legend-dot model"></span> Modèle</div>
            <div class="legend-item"><span class="legend-dot controller"></span> Contrôleur</div>
        </div>
    </div>

    <div class="uml-canvas-wrapper">
        <div class="grid-overlay"></div>
        <svg id="uml-svg" viewBox="0 0 900 620" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <!-- Arrow markers -->
                <marker id="arrow-solid" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#4a9eff"/>
                </marker>
                <marker id="arrow-dashed" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="#a78bfa"/>
                </marker>
                <marker id="diamond-open" markerWidth="12" markerHeight="8" refX="0" refY="4" orient="auto">
                    <polygon points="0 4, 5 0, 10 4, 5 8" fill="none" stroke="#4a9eff" stroke-width="1.5"/>
                </marker>
                <marker id="arrow-inherit" markerWidth="12" markerHeight="10" refX="11" refY="5" orient="auto">
                    <polygon points="0 0, 11 5, 0 10" fill="none" stroke="#34d399" stroke-width="1.5"/>
                </marker>

                <!-- Glow filters -->
                <filter id="glow-blue">
                    <feGaussianBlur stdDeviation="3" result="blur"/>
                    <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                </filter>
                <filter id="glow-purple">
                    <feGaussianBlur stdDeviation="2" result="blur"/>
                    <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                </filter>

                <!-- Class background gradient -->
                <linearGradient id="grad-model" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#1e3a5f;stop-opacity:1"/>
                    <stop offset="100%" style="stop-color:#0f2040;stop-opacity:1"/>
                </linearGradient>
                <linearGradient id="grad-controller" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#2d1b4e;stop-opacity:1"/>
                    <stop offset="100%" style="stop-color:#1a0f30;stop-opacity:1"/>
                </linearGradient>
                <linearGradient id="grad-header-model" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#1d4ed8;stop-opacity:1"/>
                    <stop offset="100%" style="stop-color:#2563eb;stop-opacity:1"/>
                </linearGradient>
                <linearGradient id="grad-header-ctrl" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#7c3aed;stop-opacity:1"/>
                    <stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:1"/>
                </linearGradient>
            </defs>

            <!-- ===================== RELATIONSHIPS ===================== -->

            <!-- Categorie (1) ---> Livre (N) : composition -->
            <line x1="280" y1="120" x2="380" y2="120"
                  stroke="#4a9eff" stroke-width="2"
                  marker-start="url(#diamond-open)"
                  marker-end="url(#arrow-solid)"
                  class="rel-line"/>
            <text x="328" y="112" text-anchor="middle" font-family="JetBrains Mono" font-size="11" fill="#4a9eff">1</text>
            <text x="370" y="112" text-anchor="middle" font-family="JetBrains Mono" font-size="11" fill="#4a9eff">*</text>
            <text x="328" y="140" text-anchor="middle" font-family="JetBrains Mono" font-size="9" fill="#6b9fd4" letter-spacing="0.5">contient</text>

            <!-- Livre --> Emprunt -->
            <line x1="550" y1="220" x2="660" y2="270"
                  stroke="#4a9eff" stroke-width="2"
                  marker-end="url(#arrow-solid)"
                  class="rel-line"/>
            <text x="605" y="240" text-anchor="middle" font-family="JetBrains Mono" font-size="11" fill="#4a9eff">1</text>
            <text x="650" y="262" text-anchor="middle" font-family="JetBrains Mono" font-size="11" fill="#4a9eff">*</text>

            <!-- Utilisateur --> Emprunt -->
            <line x1="340" y1="390" x2="660" y2="340"
                  stroke="#4a9eff" stroke-width="2"
                  marker-end="url(#arrow-solid)"
                  class="rel-line"/>
            <text x="490" y="355" text-anchor="middle" font-family="JetBrains Mono" font-size="11" fill="#4a9eff">1</text>
            <text x="650" y="338" text-anchor="middle" font-family="JetBrains Mono" font-size="11" fill="#4a9eff">*</text>

            <!-- AccueilController ..> Categorie -->
            <line x1="610" y1="490" x2="150" y2="230"
                  stroke="#a78bfa" stroke-width="1.5" stroke-dasharray="6,4"
                  marker-end="url(#arrow-dashed)"
                  class="rel-line dep"/>
            <text x="380" y="365" text-anchor="middle" font-family="JetBrains Mono" font-size="9" fill="#a78bfa" letter-spacing="0.3">«use»</text>

            <!-- AccueilController ..> Livre -->
            <line x1="610" y1="490" x2="420" y2="230"
                  stroke="#a78bfa" stroke-width="1.5" stroke-dasharray="6,4"
                  marker-end="url(#arrow-dashed)"
                  class="rel-line dep"/>
            <text x="515" y="380" text-anchor="middle" font-family="JetBrains Mono" font-size="9" fill="#a78bfa" letter-spacing="0.3">«use»</text>

            <!-- AccueilController ..> Utilisateur -->
            <line x1="610" y1="490" x2="340" y2="430"
                  stroke="#a78bfa" stroke-width="1.5" stroke-dasharray="6,4"
                  marker-end="url(#arrow-dashed)"
                  class="rel-line dep"/>

            <!-- ===================== CLASS: Categorie ===================== -->
            <g class="uml-class" transform="translate(40, 50)">
                <!-- Shadow -->
                <rect x="4" y="4" width="200" height="170" rx="6" fill="rgba(0,0,0,0.4)"/>
                <!-- Body -->
                <rect x="0" y="0" width="200" height="170" rx="6" fill="url(#grad-model)" stroke="#2563eb" stroke-width="1.5"/>
                <!-- Stereotype -->
                <rect x="0" y="0" width="200" height="22" rx="6" fill="none"/>
                <rect x="0" y="6" width="200" height="16" fill="none"/>
                <text x="100" y="17" text-anchor="middle" font-family="JetBrains Mono" font-size="9" fill="#93c5fd" letter-spacing="1">«model»</text>
                <!-- Header -->
                <rect x="0" y="22" width="200" height="32" fill="url(#grad-header-model)" rx="0"/>
                <text x="100" y="43" text-anchor="middle" font-family="Syne" font-size="15" font-weight="700" fill="white">Categorie</text>
                <!-- Divider -->
                <line x1="0" y1="54" x2="200" y2="54" stroke="#2563eb" stroke-width="1"/>
                <!-- Attributes -->
                <text x="12" y="71" font-family="JetBrains Mono" font-size="11" fill="#93c5fd">– id : int</text>
                <text x="12" y="87" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ nom : string</text>
                <text x="12" y="103" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ description : text</text>
                <text x="12" y="119" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ slug : string</text>
                <text x="12" y="135" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ active : bool</text>
                <!-- Methods divider -->
                <line x1="0" y1="145" x2="200" y2="145" stroke="#1e3a5f" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="12" y="161" font-family="JetBrains Mono" font-size="11" fill="#60a5fa">+ livres()</text>
            </g>

            <!-- ===================== CLASS: Livre ===================== -->
            <g class="uml-class" transform="translate(380, 50)">
                <rect x="4" y="4" width="200" height="185" rx="6" fill="rgba(0,0,0,0.4)"/>
                <rect x="0" y="0" width="200" height="185" rx="6" fill="url(#grad-model)" stroke="#2563eb" stroke-width="1.5"/>
                <text x="100" y="17" text-anchor="middle" font-family="JetBrains Mono" font-size="9" fill="#93c5fd" letter-spacing="1">«model»</text>
                <rect x="0" y="22" width="200" height="32" fill="url(#grad-header-model)"/>
                <text x="100" y="43" text-anchor="middle" font-family="Syne" font-size="15" font-weight="700" fill="white">Livre</text>
                <line x1="0" y1="54" x2="200" y2="54" stroke="#2563eb" stroke-width="1"/>
                <text x="12" y="71" font-family="JetBrains Mono" font-size="11" fill="#93c5fd">– id : int</text>
                <text x="12" y="87" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ titre : string</text>
                <text x="12" y="103" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ auteur : string</text>
                <text x="12" y="119" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ isbn : string</text>
                <text x="12" y="135" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ disponible : bool</text>
                <text x="12" y="151" font-family="JetBrains Mono" font-size="11" fill="#93c5fd">– categorie_id : int</text>
                <line x1="0" y1="160" x2="200" y2="160" stroke="#1e3a5f" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="12" y="176" font-family="JetBrains Mono" font-size="11" fill="#60a5fa">+ categorie()</text>
            </g>

            <!-- ===================== CLASS: Utilisateur ===================== -->
            <g class="uml-class" transform="translate(100, 330)">
                <rect x="4" y="4" width="200" height="170" rx="6" fill="rgba(0,0,0,0.4)"/>
                <rect x="0" y="0" width="200" height="170" rx="6" fill="url(#grad-model)" stroke="#2563eb" stroke-width="1.5"/>
                <text x="100" y="17" text-anchor="middle" font-family="JetBrains Mono" font-size="9" fill="#93c5fd" letter-spacing="1">«model»</text>
                <rect x="0" y="22" width="200" height="32" fill="url(#grad-header-model)"/>
                <text x="100" y="43" text-anchor="middle" font-family="Syne" font-size="15" font-weight="700" fill="white">Utilisateur</text>
                <line x1="0" y1="54" x2="200" y2="54" stroke="#2563eb" stroke-width="1"/>
                <text x="12" y="71" font-family="JetBrains Mono" font-size="11" fill="#93c5fd">– id : int</text>
                <text x="12" y="87" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ nom : string</text>
                <text x="12" y="103" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ courriel : string</text>
                <text x="12" y="119" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ role : enum</text>
                <text x="12" y="135" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ password : string</text>
                <line x1="0" y1="145" x2="200" y2="145" stroke="#1e3a5f" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="12" y="161" font-family="JetBrains Mono" font-size="11" fill="#60a5fa">+ emprunts()</text>
            </g>

            <!-- ===================== CLASS: Emprunt ===================== -->
            <g class="uml-class" transform="translate(650, 255)">
                <rect x="4" y="4" width="210" height="190" rx="6" fill="rgba(0,0,0,0.4)"/>
                <rect x="0" y="0" width="210" height="190" rx="6" fill="url(#grad-model)" stroke="#2563eb" stroke-width="1.5"/>
                <text x="105" y="17" text-anchor="middle" font-family="JetBrains Mono" font-size="9" fill="#93c5fd" letter-spacing="1">«model»</text>
                <rect x="0" y="22" width="210" height="32" fill="url(#grad-header-model)"/>
                <text x="105" y="43" text-anchor="middle" font-family="Syne" font-size="15" font-weight="700" fill="white">Emprunt</text>
                <line x1="0" y1="54" x2="210" y2="54" stroke="#2563eb" stroke-width="1"/>
                <text x="12" y="71" font-family="JetBrains Mono" font-size="11" fill="#93c5fd">– id : int</text>
                <text x="12" y="87" font-family="JetBrains Mono" font-size="11" fill="#93c5fd">– livre_id : int</text>
                <text x="12" y="103" font-family="JetBrains Mono" font-size="11" fill="#93c5fd">– utilisateur_id : int</text>
                <text x="12" y="119" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ date_emprunt : date</text>
                <text x="12" y="135" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ date_retour : date</text>
                <text x="12" y="151" font-family="JetBrains Mono" font-size="11" fill="#bfdbfe">+ statut : enum</text>
                <line x1="0" y1="161" x2="210" y2="161" stroke="#1e3a5f" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="12" y="177" font-family="JetBrains Mono" font-size="11" fill="#60a5fa">+ livre()</text>
            </g>

            <!-- ===================== CLASS: AccueilController ===================== -->
            <g class="uml-class" transform="translate(500, 490)">
                <rect x="4" y="4" width="220" height="115" rx="6" fill="rgba(0,0,0,0.4)"/>
                <rect x="0" y="0" width="220" height="115" rx="6" fill="url(#grad-controller)" stroke="#7c3aed" stroke-width="1.5"/>
                <text x="110" y="17" text-anchor="middle" font-family="JetBrains Mono" font-size="9" fill="#c4b5fd" letter-spacing="1">«controller»</text>
                <rect x="0" y="22" width="220" height="32" fill="url(#grad-header-ctrl)"/>
                <text x="110" y="43" text-anchor="middle" font-family="Syne" font-size="14" font-weight="700" fill="white">AccueilController</text>
                <line x1="0" y1="54" x2="220" y2="54" stroke="#7c3aed" stroke-width="1"/>
                <line x1="0" y1="68" x2="220" y2="68" stroke="#2d1b4e" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="12" y="85" font-family="JetBrains Mono" font-size="11" fill="#c4b5fd">+ index() : View</text>
                <text x="12" y="101" font-family="JetBrains Mono" font-size="11" fill="#ddd6fe">+ show($id) : View</text>
            </g>

        </svg>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&family=Syne:wght@400;600;700;800&display=swap');

    .uml-page {
        font-family: 'Syne', sans-serif;
        background: #060d1a;
        min-height: 100vh;
        padding: 32px;
        color: #e2e8f0;
    }

    .uml-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 28px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .uml-badge {
        display: inline-block;
        background: linear-gradient(90deg, #1d4ed8, #7c3aed);
        color: white;
        font-family: 'JetBrains Mono', monospace;
        font-size: 10px;
        letter-spacing: 2px;
        padding: 3px 10px;
        border-radius: 20px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .uml-title {
        font-size: 26px;
        font-weight: 800;
        margin: 0 0 4px 0;
        background: linear-gradient(90deg, #60a5fa, #a78bfa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .uml-subtitle {
        font-family: 'JetBrains Mono', monospace;
        font-size: 12px;
        color: #4a6fa5;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .uml-legend {
        display: flex;
        gap: 18px;
        align-items: center;
        flex-wrap: wrap;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 10px;
        padding: 12px 18px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        color: #94a3b8;
    }

    .legend-line {
        display: inline-block;
        width: 28px;
        height: 2px;
        border-radius: 2px;
    }

    .legend-line.solid { background: #4a9eff; }
    .legend-line.dashed {
        background: none;
        border-top: 2px dashed #a78bfa;
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 2px;
        display: inline-block;
    }
    .legend-dot.model { background: #2563eb; }
    .legend-dot.controller { background: #7c3aed; }

    .uml-canvas-wrapper {
        position: relative;
        background: #080f1e;
        border: 1px solid rgba(37, 99, 235, 0.2);
        border-radius: 16px;
        overflow: hidden;
        box-shadow:
            0 0 0 1px rgba(37, 99, 235, 0.1),
            0 20px 80px rgba(0, 0, 0, 0.6),
            inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .grid-overlay {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(37, 99, 235, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(37, 99, 235, 0.04) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }

    #uml-svg {
        width: 100%;
        height: auto;
        display: block;
        padding: 20px;
    }

    .uml-class {
        transition: transform 0.2s ease;
        cursor: default;
    }

    .uml-class:hover {
        filter: drop-shadow(0 0 12px rgba(74, 158, 255, 0.4));
    }

    .rel-line {
        transition: stroke-opacity 0.2s;
    }

    .rel-line.dep:hover {
        stroke: #c4b5fd;
    }
</style>
@endsectionbsa
@extends('layouts.app')

@section('title', 'Diagramme UML')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="uml-wrapper">

    <div class="uml-header">
        <div>
            <h2 class="uml-title">Diagramme de Classes — BiblioTech</h2>
            <p class="uml-sub">Structure des modèles, relations et contrôleurs · Laravel MVC</p>
        </div>
        <div class="uml-legend">
            <span class="leg-item">
                <svg width="36" height="16" viewBox="0 0 36 16" overflow="visible">
                    <line x1="2" y1="8" x2="30" y2="8" stroke="#2563eb" stroke-width="1.5"/>
                    <polygon points="24,5 30,8 24,11" fill="#2563eb"/>
                </svg>
                Association
            </span>
            <span class="leg-item">
                <svg width="36" height="16" viewBox="0 0 36 16" overflow="visible">
                    <line x1="2" y1="8" x2="30" y2="8" stroke="#7c3aed" stroke-width="1.5" stroke-dasharray="5,3"/>
                    <polygon points="24,5 30,8 24,11" fill="#7c3aed"/>
                </svg>
                Dépendance «use»
            </span>
            <span class="leg-item"><span class="leg-dot blue"></span> Modèle</span>
            <span class="leg-item"><span class="leg-dot purple"></span> Contrôleur</span>
        </div>
    </div>

    <div class="uml-canvas">
        <svg id="uml-svg" viewBox="0 0 980 660" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <marker id="arr-blue" markerWidth="10" markerHeight="8" refX="9" refY="4" orient="auto">
                    <polygon points="0 0, 10 4, 0 8" fill="#2563eb"/>
                </marker>
                <marker id="arr-purple" markerWidth="10" markerHeight="8" refX="9" refY="4" orient="auto">
                    <polygon points="0 0, 10 4, 0 8" fill="#7c3aed"/>
                </marker>
                <filter id="shadow" x="-5%" y="-5%" width="115%" height="120%">
                    <feDropShadow dx="0" dy="2" stdDeviation="4" flood-color="#00000012"/>
                </filter>
            </defs>

            <!-- ① Categorie (1) ——> (*) Livre — simple association -->
            <line x1="252" y1="110" x2="338" y2="110"
                  stroke="#2563eb" stroke-width="1.5"
                  marker-end="url(#arr-blue)"/>
            <text x="242" y="103" font-family="Inter" font-size="11" fill="#2563eb" font-weight="600">1</text>
            <text x="342" y="103" font-family="Inter" font-size="11" fill="#2563eb" font-weight="600">*</text>
            <text x="295" y="128" font-family="Inter" font-size="10" fill="#6b7280" text-anchor="middle" font-style="italic">contient</text>

            <!-- ② Livre (1) ——> (*) Emprunt -->
            <line x1="552" y1="150" x2="668" y2="285"
                  stroke="#2563eb" stroke-width="1.5"
                  marker-end="url(#arr-blue)"/>
            <text x="558" y="143" font-family="Inter" font-size="11" fill="#2563eb" font-weight="600">1</text>
            <text x="654" y="282" font-family="Inter" font-size="11" fill="#2563eb" font-weight="600">*</text>

            <!-- ③ Utilisateur (1) ——> (*) Emprunt -->
            <line x1="252" y1="428" x2="668" y2="368"
                  stroke="#2563eb" stroke-width="1.5"
                  marker-end="url(#arr-blue)"/>
            <text x="258" y="421" font-family="Inter" font-size="11" fill="#2563eb" font-weight="600">1</text>
            <text x="654" y="363" font-family="Inter" font-size="11" fill="#2563eb" font-weight="600">*</text>

            <!-- ④ AccueilController - -> Categorie -->
            <line x1="415" y1="500" x2="148" y2="235"
                  stroke="#7c3aed" stroke-width="1.5" stroke-dasharray="6,4"
                  marker-end="url(#arr-purple)"/>
            <text x="268" y="390" font-family="Inter" font-size="10" fill="#7c3aed"
                  font-style="italic" transform="rotate(-30, 268, 390)">«use»</text>

            <!-- ⑤ AccueilController - -> Livre -->
            <line x1="489" y1="500" x2="446" y2="252"
                  stroke="#7c3aed" stroke-width="1.5" stroke-dasharray="6,4"
                  marker-end="url(#arr-purple)"/>
            <text x="492" y="418" font-family="Inter" font-size="10" fill="#7c3aed" font-style="italic">«use»</text>

            <!-- ⑥ AccueilController - -> Utilisateur -->
            <line x1="372" y1="535" x2="252" y2="525"
                  stroke="#7c3aed" stroke-width="1.5" stroke-dasharray="6,4"
                  marker-end="url(#arr-purple)"/>
            <text x="307" y="522" font-family="Inter" font-size="10" fill="#7c3aed"
                  font-style="italic" text-anchor="middle">«use»</text>


            <!-- ================================================================ -->
            <!--  CLASSE : Categorie  (x=40, y=50, w=212, h=183)                 -->
            <!--  bord droit x=252                                                -->
            <!-- ================================================================ -->
            <g class="cls" transform="translate(40, 50)" filter="url(#shadow)">
                <rect width="212" height="183" rx="6" fill="white" stroke="#d1d5db" stroke-width="1"/>
                <rect width="212" height="46" rx="6" fill="#2563eb"/>
                <rect y="38" width="212" height="8" fill="#2563eb"/>
                <text x="106" y="15" text-anchor="middle" font-family="Inter" font-size="9" fill="#bfdbfe" letter-spacing="1.5">«model»</text>
                <text x="106" y="33" text-anchor="middle" font-family="Inter" font-size="14" font-weight="600" fill="white">Categorie</text>
                <line x1="0" y1="46" x2="212" y2="46" stroke="#e5e7eb" stroke-width="1"/>
                <text x="14" y="64"  font-family="Inter" font-size="11" fill="#9ca3af">- id : int</text>
                <text x="14" y="81"  font-family="Inter" font-size="11" fill="#374151">+ nom : string</text>
                <text x="14" y="98"  font-family="Inter" font-size="11" fill="#374151">+ description : text</text>
                <text x="14" y="115" font-family="Inter" font-size="11" fill="#374151">+ slug : string</text>
                <text x="14" y="132" font-family="Inter" font-size="11" fill="#374151">+ active : bool</text>
                <line x1="0" y1="144" x2="212" y2="144" stroke="#e5e7eb" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="14" y="162" font-family="Inter" font-size="11" fill="#2563eb">+ livres() : Collection</text>
            </g>

            <!-- ================================================================ -->
            <!--  CLASSE : Livre  (x=340, y=50, w=212, h=200)                    -->
            <!--  bord gauche x=340, bord droit x=552, bas y=250                 -->
            <!-- ================================================================ -->
            <g class="cls" transform="translate(340, 50)" filter="url(#shadow)">
                <rect width="212" height="200" rx="6" fill="white" stroke="#d1d5db" stroke-width="1"/>
                <rect width="212" height="46" rx="6" fill="#2563eb"/>
                <rect y="38" width="212" height="8" fill="#2563eb"/>
                <text x="106" y="15" text-anchor="middle" font-family="Inter" font-size="9" fill="#bfdbfe" letter-spacing="1.5">«model»</text>
                <text x="106" y="33" text-anchor="middle" font-family="Inter" font-size="14" font-weight="600" fill="white">Livre</text>
                <line x1="0" y1="46" x2="212" y2="46" stroke="#e5e7eb" stroke-width="1"/>
                <text x="14" y="64"  font-family="Inter" font-size="11" fill="#9ca3af">- id : int</text>
                <text x="14" y="81"  font-family="Inter" font-size="11" fill="#374151">+ titre : string</text>
                <text x="14" y="98"  font-family="Inter" font-size="11" fill="#374151">+ auteur : string</text>
                <text x="14" y="115" font-family="Inter" font-size="11" fill="#374151">+ isbn : string</text>
                <text x="14" y="132" font-family="Inter" font-size="11" fill="#374151">+ disponible : bool</text>
                <text x="14" y="149" font-family="Inter" font-size="11" fill="#9ca3af">- categorie_id : int</text>
                <line x1="0" y1="161" x2="212" y2="161" stroke="#e5e7eb" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="14" y="179" font-family="Inter" font-size="11" fill="#2563eb">+ categorie() : Categorie</text>
            </g>

            <!-- ================================================================ -->
            <!--  CLASSE : Emprunt  (x=670, y=270, w=222, h=200)                 -->
            <!-- ================================================================ -->
            <g class="cls" transform="translate(670, 270)" filter="url(#shadow)">
                <rect width="222" height="200" rx="6" fill="white" stroke="#d1d5db" stroke-width="1"/>
                <rect width="222" height="46" rx="6" fill="#2563eb"/>
                <rect y="38" width="222" height="8" fill="#2563eb"/>
                <text x="111" y="15" text-anchor="middle" font-family="Inter" font-size="9" fill="#bfdbfe" letter-spacing="1.5">«model»</text>
                <text x="111" y="33" text-anchor="middle" font-family="Inter" font-size="14" font-weight="600" fill="white">Emprunt</text>
                <line x1="0" y1="46" x2="222" y2="46" stroke="#e5e7eb" stroke-width="1"/>
                <text x="14" y="64"  font-family="Inter" font-size="11" fill="#9ca3af">- id : int</text>
                <text x="14" y="81"  font-family="Inter" font-size="11" fill="#9ca3af">- livre_id : int</text>
                <text x="14" y="98"  font-family="Inter" font-size="11" fill="#9ca3af">- utilisateur_id : int</text>
                <text x="14" y="115" font-family="Inter" font-size="11" fill="#374151">+ date_emprunt : date</text>
                <text x="14" y="132" font-family="Inter" font-size="11" fill="#374151">+ date_retour : date</text>
                <text x="14" y="149" font-family="Inter" font-size="11" fill="#374151">+ statut : enum</text>
                <line x1="0" y1="161" x2="222" y2="161" stroke="#e5e7eb" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="14" y="179" font-family="Inter" font-size="11" fill="#2563eb">+ livre() : Livre</text>
            </g>

            <!-- ================================================================ -->
            <!--  CLASSE : Utilisateur  (x=40, y=340, w=212, h=183)              -->
            <!--  bord droit x=252, bas y=523                                    -->
            <!-- ================================================================ -->
            <g class="cls" transform="translate(40, 340)" filter="url(#shadow)">
                <rect width="212" height="183" rx="6" fill="white" stroke="#d1d5db" stroke-width="1"/>
                <rect width="212" height="46" rx="6" fill="#2563eb"/>
                <rect y="38" width="212" height="8" fill="#2563eb"/>
                <text x="106" y="15" text-anchor="middle" font-family="Inter" font-size="9" fill="#bfdbfe" letter-spacing="1.5">«model»</text>
                <text x="106" y="33" text-anchor="middle" font-family="Inter" font-size="14" font-weight="600" fill="white">Utilisateur</text>
                <line x1="0" y1="46" x2="212" y2="46" stroke="#e5e7eb" stroke-width="1"/>
                <text x="14" y="64"  font-family="Inter" font-size="11" fill="#9ca3af">- id : int</text>
                <text x="14" y="81"  font-family="Inter" font-size="11" fill="#374151">+ nom : string</text>
                <text x="14" y="98"  font-family="Inter" font-size="11" fill="#374151">+ courriel : string</text>
                <text x="14" y="115" font-family="Inter" font-size="11" fill="#374151">+ role : enum</text>
                <text x="14" y="132" font-family="Inter" font-size="11" fill="#374151">+ password : string</text>
                <line x1="0" y1="144" x2="212" y2="144" stroke="#e5e7eb" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="14" y="162" font-family="Inter" font-size="11" fill="#2563eb">+ emprunts() : Collection</text>
            </g>

            <!-- ================================================================ -->
            <!--  CLASSE : AccueilController  (x=372, y=500, w=238, h=130)       -->
            <!-- ================================================================ -->
            <g class="cls ctrl" transform="translate(372, 500)" filter="url(#shadow)">
                <rect width="238" height="130" rx="6" fill="white" stroke="#d1d5db" stroke-width="1"/>
                <rect width="238" height="46" rx="6" fill="#7c3aed"/>
                <rect y="38" width="238" height="8" fill="#7c3aed"/>
                <text x="119" y="15" text-anchor="middle" font-family="Inter" font-size="9" fill="#ddd6fe" letter-spacing="1.5">«controller»</text>
                <text x="119" y="33" text-anchor="middle" font-family="Inter" font-size="13" font-weight="600" fill="white">AccueilController</text>
                <line x1="0" y1="46" x2="238" y2="46" stroke="#e5e7eb" stroke-width="1"/>
                <line x1="0" y1="60" x2="238" y2="60" stroke="#e5e7eb" stroke-width="1" stroke-dasharray="4,3"/>
                <text x="14" y="78"  font-family="Inter" font-size="11" fill="#7c3aed">+ index() : View</text>
                <text x="14" y="95"  font-family="Inter" font-size="11" fill="#374151">+ show(int $id) : View</text>
                <text x="14" y="112" font-family="Inter" font-size="11" fill="#374151">+ accueil() : View</text>
            </g>

        </svg>
    </div>

    <p class="uml-note">UML 2.0 · BiblioTech · Formation BTS SIO SLAM · Séance 1</p>
</div>

<style>
.uml-wrapper {
    font-family: 'Inter', sans-serif;
    max-width: 1100px;
    margin: 32px auto;
    padding: 0 24px 48px;
}
.uml-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 20px;
}
.uml-title {
    font-size: 20px;
    font-weight: 600;
    color: #111827;
    margin: 0 0 4px;
}
.uml-sub {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}
.uml-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    align-items: center;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 10px 18px;
}
.leg-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #4b5563;
}
.leg-dot {
    width: 10px;
    height: 10px;
    border-radius: 3px;
    display: inline-block;
}
.leg-dot.blue   { background: #2563eb; }
.leg-dot.purple { background: #7c3aed; }
.uml-canvas {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
}
#uml-svg {
    width: 100%;
    height: auto;
    display: block;
    padding: 16px;
    box-sizing: border-box;
}
.cls { cursor: default; }
.cls:hover {
    filter: drop-shadow(0 6px 18px rgba(37, 99, 235, 0.18)) !important;
}
.cls.ctrl:hover {
    filter: drop-shadow(0 6px 18px rgba(124, 58, 237, 0.18)) !important;
}
.uml-note {
    text-align: right;
    font-size: 11px;
    color: #9ca3af;
    margin: 10px 0 0;
}
</style>
@endsection
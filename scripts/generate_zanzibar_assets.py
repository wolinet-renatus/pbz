#!/usr/bin/env python3
"""
Generate Zanzibar and PBZ Bank corporate visual assets:
- Course Thumbnails (AML/CFT, Islamic Banking Amana, Cyber Hygiene)
- Event Covers (BOT Summit, Islamic FinTech, Cyber Workshop, Wakala Forum)
- Blog Covers (Risk Guidelines, Shariah Banking, Zero-Trust, Branch Ops, Blue Economy, Mobile Journeys)
- About & Choose-Us Zanzibar graphics (Dhow sailboat, Clove spice crest, BOT Seal, Islamic Arch)
"""

import os
from PIL import Image, ImageDraw, ImageFont

def ensure_dir(path):
    os.makedirs(os.path.dirname(path), exist_ok=True)

# -------------------------------------------------------------
# 1. SVG GENERATION FOR COURSES, EVENTS, BLOGS, ABOUT
# -------------------------------------------------------------

def svg_course_aml():
    return '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 480" width="100%" height="100%">
  <defs>
    <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#072818"/>
      <stop offset="50%" stop-color="#006837"/>
      <stop offset="100%" stop-color="#004d27"/>
    </linearGradient>
    <linearGradient id="cyanGrad" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#32C5F1"/>
      <stop offset="100%" stop-color="#00a8e8"/>
    </linearGradient>
    <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#F9ED27"/>
      <stop offset="100%" stop-color="#d4af37"/>
    </linearGradient>
    <filter id="shadow" x="-10%" y="-10%" width="120%" height="120%">
      <feDropShadow dx="0" dy="8" stdDeviation="12" flood-color="#000000" flood-opacity="0.35"/>
    </filter>
  </defs>

  <!-- Background -->
  <rect width="800" height="480" fill="url(#bgGrad)"/>

  <!-- Subtle Islamic / Zanzibar Geometric Motifs -->
  <g opacity="0.08" stroke="#ffffff" stroke-width="1.5" fill="none">
    <circle cx="700" cy="80" r="140"/>
    <circle cx="700" cy="80" r="100"/>
    <circle cx="700" cy="80" r="60"/>
    <rect x="630" y="10" width="140" height="140" transform="rotate(45 700 80)"/>
    <circle cx="100" cy="400" r="180"/>
  </g>

  <!-- Wave Accent representing Zanzibar Channel -->
  <path d="M0,420 C200,380 450,450 800,400 L800,480 L0,480 Z" fill="#041a10" opacity="0.6"/>
  <path d="M0,440 C280,410 500,470 800,430 L800,480 L0,480 Z" fill="url(#cyanGrad)" opacity="0.25"/>

  <!-- PBZ Bank Header Bar -->
  <g transform="translate(50, 45)">
    <rect width="180" height="34" rx="17" fill="#ffffff" opacity="0.12"/>
    <circle cx="20" cy="17" r="7" fill="#F9ED27"/>
    <text x="36" y="22" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="700" fill="#32C5F1" letter-spacing="1">PBZ ACADEMY</text>
    <rect x="195" y="0" width="130" height="34" rx="17" fill="url(#goldGrad)" opacity="0.95"/>
    <text x="212" y="22" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="800" fill="#072818" letter-spacing="0.5">BOT COMPLIANT</text>
  </g>

  <!-- Main Illustration: Compliance Shield & Scale of Justice -->
  <g transform="translate(560, 230)" filter="url(#shadow)">
    <!-- Shield Outer -->
    <path d="M0,-110 C80,-110 130,-70 130,10 C130,85 40,135 0,155 C-40,135 -130,85 -130,10 C-130,-70 -80,-110 0,-110 Z" fill="#062215" stroke="url(#goldGrad)" stroke-width="4"/>
    <!-- Shield Inner Glow -->
    <path d="M0,-95 C68,-95 110,-60 110,10 C110,75 35,118 0,135 C-35,118 -110,75 -110,10 C-110,-60 -68,-95 0,-95 Z" fill="#0a3320" stroke="#32C5F1" stroke-width="1.5" opacity="0.8"/>
    
    <!-- Fingerprint / Biometric KYC lines -->
    <path d="M-40,20 C-40,-20 40,-20 40,20" fill="none" stroke="#32C5F1" stroke-width="3" stroke-linecap="round" opacity="0.7"/>
    <path d="M-25,20 C-25,-8 25,-8 25,20" fill="none" stroke="#32C5F1" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
    <path d="M-10,20 C-10,4 10,4 10,20" fill="none" stroke="#F9ED27" stroke-width="3" stroke-linecap="round"/>
    
    <!-- Scales of Justice Symbol -->
    <line x1="0" y1="-65" x2="0" y2="-15" stroke="url(#goldGrad)" stroke-width="4" stroke-linecap="round"/>
    <line x1="-50" y1="-45" x2="50" y2="-45" stroke="url(#goldGrad)" stroke-width="3" stroke-linecap="round"/>
    <!-- Left Pan -->
    <line x1="-50" y1="-45" x2="-65" y2="-20" stroke="#F9ED27" stroke-width="1.5"/>
    <line x1="-50" y1="-45" x2="-35" y2="-20" stroke="#F9ED27" stroke-width="1.5"/>
    <path d="M-72,-20 C-65,-12 -35,-12 -28,-20 Z" fill="url(#goldGrad)"/>
    <!-- Right Pan -->
    <line x1="50" y1="-45" x2="35" y2="-20" stroke="#F9ED27" stroke-width="1.5"/>
    <line x1="50" y1="-45" x2="65" y2="-20" stroke="#F9ED27" stroke-width="1.5"/>
    <path d="M28,-20 C35,-12 65,-12 72,-20 Z" fill="url(#goldGrad)"/>
    <!-- Central Jewel -->
    <circle cx="0" cy="-65" r="7" fill="url(#goldGrad)"/>
    <circle cx="0" cy="-15" r="4" fill="#32C5F1"/>
  </g>

  <!-- Typography Left Side -->
  <g transform="translate(50, 130)">
    <text x="0" y="30" font-family="'Inter', system-ui, sans-serif" font-size="14" font-weight="600" fill="#32C5F1" letter-spacing="2">MANDATORY ANNUAL CERTIFICATION</text>
    <text x="0" y="80" font-family="'Inter', system-ui, sans-serif" font-size="34" font-weight="900" fill="#ffffff" letter-spacing="-0.5">AML / CFT &amp; KYC</text>
    <text x="0" y="125" font-family="'Inter', system-ui, sans-serif" font-size="28" font-weight="800" fill="#F9ED27">Regulatory Compliance 2026</text>
    
    <text x="0" y="175" font-family="'Inter', system-ui, sans-serif" font-size="16" font-weight="400" fill="#cbd5e1" width="450">
      Bank of Tanzania Statutory Directives, PEP &amp; Sanctions Screening,
    </text>
    <text x="0" y="200" font-family="'Inter', system-ui, sans-serif" font-size="16" font-weight="400" fill="#cbd5e1">
      Transaction Monitoring &amp; Suspicious Activity Reporting (SAR).
    </text>

    <!-- Badges Row -->
    <g transform="translate(0, 240)">
      <rect width="110" height="32" rx="8" fill="#ffffff" opacity="0.1"/>
      <text x="14" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="600" fill="#ffffff">4 Modules</text>

      <rect x="122" y="0" width="120" height="32" rx="8" fill="#ffffff" opacity="0.1"/>
      <text x="136" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="600" fill="#ffffff">18 Lessons</text>

      <rect x="254" y="0" width="150" height="32" rx="8" fill="#32C5F1" opacity="0.2"/>
      <text x="268" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="700" fill="#32C5F1">Official Certificate</text>
    </g>
  </g>
</svg>'''

def svg_course_islamic():
    return '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 480" width="100%" height="100%">
  <defs>
    <linearGradient id="bgGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#022115"/>
      <stop offset="50%" stop-color="#005a30"/>
      <stop offset="100%" stop-color="#03381e"/>
    </linearGradient>
    <linearGradient id="goldGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#FFE066"/>
      <stop offset="50%" stop-color="#F9ED27"/>
      <stop offset="100%" stop-color="#B8860B"/>
    </linearGradient>
    <linearGradient id="cyanGrad2" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#64D8F8"/>
      <stop offset="100%" stop-color="#0099D8"/>
    </linearGradient>
    <filter id="shadow2" x="-10%" y="-10%" width="120%" height="120%">
      <feDropShadow dx="0" dy="8" stdDeviation="14" flood-color="#000000" flood-opacity="0.4"/>
    </filter>
  </defs>

  <!-- Background -->
  <rect width="800" height="480" fill="url(#bgGrad2)"/>

  <!-- Islamic Geometric Rosette & Star Lattice Pattern -->
  <g opacity="0.12" stroke="url(#goldGrad2)" stroke-width="1.5" fill="none">
    <g transform="translate(620, 240)">
      <polygon points="0,-160 113,-113 160,0 113,113 0,160 -113,113 -160,0 -113,-113"/>
      <polygon points="0,-160 113,-113 160,0 113,113 0,160 -113,113 -160,0 -113,-113" transform="rotate(22.5)"/>
      <polygon points="0,-160 113,-113 160,0 113,113 0,160 -113,113 -160,0 -113,-113" transform="rotate(45)"/>
      <polygon points="0,-160 113,-113 160,0 113,113 0,160 -113,113 -160,0 -113,-113" transform="rotate(67.5)"/>
      <circle cx="0" cy="0" r="120"/>
      <circle cx="0" cy="0" r="80"/>
      <circle cx="0" cy="0" r="40"/>
    </g>
  </g>

  <!-- Wave Accent -->
  <path d="M0,430 C240,400 480,460 800,420 L800,480 L0,480 Z" fill="#01180f" opacity="0.7"/>

  <!-- PBZ Amana Badge -->
  <g transform="translate(50, 45)">
    <rect width="180" height="34" rx="17" fill="#ffffff" opacity="0.12"/>
    <circle cx="20" cy="17" r="7" fill="#32C5F1"/>
    <text x="36" y="22" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="700" fill="#ffffff" letter-spacing="1">PBZ AMANA</text>
    <rect x="195" y="0" width="160" height="34" rx="17" fill="url(#goldGrad2)"/>
    <text x="210" y="22" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="800" fill="#072818" letter-spacing="0.5">SHARIAH CERTIFIED</text>
  </g>

  <!-- Central Graphic: Islamic Arch & Golden Crescent / Book -->
  <g transform="translate(620, 240)" filter="url(#shadow2)">
    <!-- Pointed Arch Doorway Motif -->
    <path d="M-85,120 L-85,-20 C-85,-90 0,-140 0,-140 C0,-140 85,-90 85,-20 L85,120 Z" fill="#072d1c" stroke="url(#goldGrad2)" stroke-width="3"/>
    <path d="M-70,120 L-70,-15 C-70,-75 0,-115 0,-115 C0,-115 70,-75 70,-15 L70,120 Z" fill="#0b4028" stroke="#32C5F1" stroke-width="1.5" opacity="0.8"/>
    
    <!-- Crescent & Star -->
    <g transform="translate(0, -25) scale(1.2)">
      <path d="M-5,-45 A32,32 0 1,0 35,5 A26,26 0 1,1 -5,-45 Z" fill="url(#goldGrad2)"/>
      <polygon points="12,-15 16,-6 26,-6 18,1 21,11 12,5 4,11 7,1 -1,-6 9,-6" fill="url(#goldGrad2)"/>
    </g>

    <!-- Open Shariah Book / Contract Scroll -->
    <g transform="translate(0, 55)">
      <path d="M-45,15 C-20,5 -5,10 0,18 C5,10 20,5 45,15 L45,-15 C20,-25 5,-20 0,-12 C-5,-20 -20,-25 -45,-15 Z" fill="#ffffff" opacity="0.95"/>
      <path d="M-40,10 C-20,2 -5,6 0,14 C5,6 20,2 40,10 L40,-10 C20,-18 5,-14 0,-7 C-5,-14 -20,-18 -40,-10 Z" fill="#f8fafc"/>
      <line x1="-32" y1="-3" x2="-8" y2="-7" stroke="#006837" stroke-width="1.5"/>
      <line x1="-32" y1="4" x2="-8" y2="0" stroke="#006837" stroke-width="1.5"/>
      <line x1="8" y1="-7" x2="32" y2="-3" stroke="#006837" stroke-width="1.5"/>
      <line x1="8" y1="0" x2="32" y2="4" stroke="#006837" stroke-width="1.5"/>
    </g>
  </g>

  <!-- Typography Left Side -->
  <g transform="translate(50, 130)">
    <text x="0" y="30" font-family="'Inter', system-ui, sans-serif" font-size="14" font-weight="600" fill="#32C5F1" letter-spacing="2">ISLAMIC BANKING OPERATIONS</text>
    <text x="0" y="80" font-family="'Inter', system-ui, sans-serif" font-size="34" font-weight="900" fill="#ffffff" letter-spacing="-0.5">PBZ Amana</text>
    <text x="0" y="125" font-family="'Inter', system-ui, sans-serif" font-size="28" font-weight="800" fill="#F9ED27">Shariah Contracts &amp; Governance</text>
    
    <text x="0" y="175" font-family="'Inter', system-ui, sans-serif" font-size="16" font-weight="400" fill="#cbd5e1">
      Murabaha, Ijara, Mudaraba, Musharaka &amp; Sukuk Financial Frameworks,
    </text>
    <text x="0" y="200" font-family="'Inter', system-ui, sans-serif" font-size="16" font-weight="400" fill="#cbd5e1">
      Shariah Board Supervisory Standards &amp; Zakat Accounting Rules.
    </text>

    <!-- Badges Row -->
    <g transform="translate(0, 240)">
      <rect width="110" height="32" rx="8" fill="#ffffff" opacity="0.1"/>
      <text x="14" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="600" fill="#ffffff">5 Modules</text>

      <rect x="122" y="0" width="120" height="32" rx="8" fill="#ffffff" opacity="0.1"/>
      <text x="136" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="600" fill="#ffffff">22 Lessons</text>

      <rect x="254" y="0" width="155" height="32" rx="8" fill="#F9ED27" opacity="0.2"/>
      <text x="268" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="700" fill="#F9ED27">Shariah Diploma</text>
    </g>
  </g>
</svg>'''

def svg_course_cyber():
    return '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 480" width="100%" height="100%">
  <defs>
    <linearGradient id="bgGrad3" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#02141c"/>
      <stop offset="50%" stop-color="#063228"/>
      <stop offset="100%" stop-color="#011b15"/>
    </linearGradient>
    <linearGradient id="cyanGrad3" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#32C5F1"/>
      <stop offset="100%" stop-color="#006699"/>
    </linearGradient>
    <linearGradient id="greenGrad3" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#00FF88"/>
      <stop offset="100%" stop-color="#006837"/>
    </linearGradient>
    <filter id="glow3" x="-20%" y="-20%" width="140%" height="140%">
      <feGaussianBlur stdDeviation="8" result="blur"/>
      <feMerge>
        <feMergeNode in="blur"/>
        <feMergeNode in="SourceGraphic"/>
      </feMerge>
    </filter>
  </defs>

  <!-- Background -->
  <rect width="800" height="480" fill="url(#bgGrad3)"/>

  <!-- Cyber Network Grid & Circuit Nodes -->
  <g opacity="0.18" stroke="#32C5F1" stroke-width="1.5" fill="none">
    <path d="M450,100 L550,100 L620,170 L720,170"/>
    <circle cx="550" cy="100" r="5" fill="#32C5F1"/>
    <circle cx="620" cy="170" r="5" fill="#00FF88"/>
    <circle cx="720" cy="170" r="6" fill="#32C5F1"/>

    <path d="M480,380 L560,380 L620,320 L750,320"/>
    <circle cx="560" cy="380" r="5" fill="#32C5F1"/>
    <circle cx="620" cy="320" r="5" fill="#00FF88"/>
    <circle cx="750" cy="320" r="6" fill="#F9ED27"/>

    <path d="M500,240 L580,240 L650,240 L700,290"/>
    <circle cx="580" cy="240" r="4" fill="#32C5F1"/>
  </g>

  <!-- PBZ Cyber Defense Badge -->
  <g transform="translate(50, 45)">
    <rect width="180" height="34" rx="17" fill="#ffffff" opacity="0.12"/>
    <circle cx="20" cy="17" r="7" fill="#00FF88"/>
    <text x="36" y="22" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="700" fill="#32C5F1" letter-spacing="1">PBZ INFOSEC</text>
    <rect x="195" y="0" width="140" height="34" rx="17" fill="url(#cyanGrad3)"/>
    <text x="210" y="22" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="800" fill="#ffffff" letter-spacing="0.5">ZERO TRUST</text>
  </g>

  <!-- Central Visual: Cyber Padlock & Core Banking Firewall Shield -->
  <g transform="translate(630, 240)" filter="url(#glow3)">
    <!-- Hexagonal Security Shield -->
    <polygon points="0,-130 110,-65 110,65 0,130 -110,65 -110,-65" fill="#041a24" stroke="#32C5F1" stroke-width="3.5"/>
    <polygon points="0,-110 90,-55 90,55 0,110 -90,55 -90,-55" fill="#07271e" stroke="#00FF88" stroke-width="1.5" opacity="0.6"/>

    <!-- Padlock Body -->
    <rect x="-42" y="-10" width="84" height="68" rx="14" fill="#0a3c4a" stroke="url(#cyanGrad3)" stroke-width="2.5"/>
    <!-- Padlock Shackle -->
    <path d="M-26,-10 L-26,-45 C-26,-62 26,-62 26,-45 L26,-10" fill="none" stroke="#F9ED27" stroke-width="8" stroke-linecap="round"/>
    
    <!-- Keyhole / Terminal Symbol -->
    <circle cx="0" cy="16" r="9" fill="#00FF88"/>
    <polygon points="-4,22 4,22 6,38 -6,38" fill="#00FF88"/>
    
    <!-- Orbiting Ring with Pulse Dots -->
    <ellipse cx="0" cy="0" rx="135" ry="50" fill="none" stroke="#32C5F1" stroke-width="1.5" stroke-dasharray="8 8" opacity="0.7" transform="rotate(-25)"/>
    <circle cx="100" cy="-45" r="5" fill="#00FF88"/>
    <circle cx="-100" cy="45" r="5" fill="#F9ED27"/>
  </g>

  <!-- Typography Left Side -->
  <g transform="translate(50, 130)">
    <text x="0" y="30" font-family="'Inter', system-ui, sans-serif" font-size="14" font-weight="600" fill="#00FF88" letter-spacing="2">BOT MANDATED CYBERSECURITY</text>
    <text x="0" y="80" font-family="'Inter', system-ui, sans-serif" font-size="34" font-weight="900" fill="#ffffff" letter-spacing="-0.5">Cyber Hygiene &amp; Defense</text>
    <text x="0" y="125" font-family="'Inter', system-ui, sans-serif" font-size="28" font-weight="800" fill="#32C5F1">Social Engineering &amp; Ransomware</text>
    
    <text x="0" y="175" font-family="'Inter', system-ui, sans-serif" font-size="16" font-weight="400" fill="#cbd5e1">
      Phishing Resilience, Credential Safeguarding, Clean Desk Protocols,
    </text>
    <text x="0" y="200" font-family="'Inter', system-ui, sans-serif" font-size="16" font-weight="400" fill="#cbd5e1">
      Incident Escalation &amp; Tanzania Data Protection Act (PDPA 2022).
    </text>

    <!-- Badges Row -->
    <g transform="translate(0, 240)">
      <rect width="110" height="32" rx="8" fill="#ffffff" opacity="0.1"/>
      <text x="14" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="600" fill="#ffffff">3 Modules</text>

      <rect x="122" y="0" width="120" height="32" rx="8" fill="#ffffff" opacity="0.1"/>
      <text x="136" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="600" fill="#ffffff">14 Lessons</text>

      <rect x="254" y="0" width="150" height="32" rx="8" fill="#00FF88" opacity="0.15"/>
      <text x="268" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="700" fill="#00FF88">SecOps Certified</text>
    </g>
  </g>
</svg>'''

# -------------------------------------------------------------
# 2. SVG GENERATION FOR EVENTS
# -------------------------------------------------------------

def svg_event(title, subtitle, tag, date_str, location_str, icon_type='bot'):
    accent_color = "#32C5F1" if icon_type == 'bot' else ("#F9ED27" if icon_type == 'islamic' else "#00FF88")
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 480" width="100%" height="100%">
  <defs>
    <linearGradient id="eGrad_{icon_type}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#041a10"/>
      <stop offset="60%" stop-color="#004d27"/>
      <stop offset="100%" stop-color="#012b16"/>
    </linearGradient>
  </defs>

  <rect width="800" height="480" fill="url(#eGrad_{icon_type})"/>

  <!-- Zanzibar Coastal Dhow Outline in Background -->
  <g opacity="0.09" stroke="#ffffff" stroke-width="2" fill="none">
    <path d="M500,320 Q620,340 740,320 C720,360 520,360 500,320 Z"/>
    <path d="M620,160 L620,320 M620,160 L540,300 L620,300 M620,180 L710,290 L620,290"/>
    <circle cx="680" cy="140" r="40"/>
  </g>

  <!-- Tag Pill -->
  <g transform="translate(50, 45)">
    <rect width="200" height="34" rx="17" fill="{accent_color}" fill-opacity="0.2" stroke="{accent_color}" stroke-width="1"/>
    <circle cx="20" cy="17" r="6" fill="{accent_color}"/>
    <text x="34" y="22" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="800" fill="#ffffff" letter-spacing="1">{tag}</text>
  </g>

  <!-- Title & Description -->
  <g transform="translate(50, 125)">
    <text x="0" y="35" font-family="'Inter', system-ui, sans-serif" font-size="32" font-weight="900" fill="#ffffff">{title}</text>
    <text x="0" y="80" font-family="'Inter', system-ui, sans-serif" font-size="22" font-weight="700" fill="{accent_color}">{subtitle}</text>
    
    <g transform="translate(0, 140)">
      <!-- Date -->
      <g>
        <circle cx="20" cy="20" r="20" fill="#ffffff" fill-opacity="0.1"/>
        <text x="50" y="16" font-family="'Inter', system-ui, sans-serif" font-size="13" font-weight="500" fill="#94a3b8">DATE &amp; TIME</text>
        <text x="50" y="34" font-family="'Inter', system-ui, sans-serif" font-size="15" font-weight="700" fill="#ffffff">{date_str}</text>
      </g>
      <!-- Location -->
      <g transform="translate(300, 0)">
        <circle cx="20" cy="20" r="20" fill="#ffffff" fill-opacity="0.1"/>
        <text x="50" y="16" font-family="'Inter', system-ui, sans-serif" font-size="13" font-weight="500" fill="#94a3b8">VENUE</text>
        <text x="50" y="34" font-family="'Inter', system-ui, sans-serif" font-size="15" font-weight="700" fill="#ffffff">{location_str}</text>
      </g>
    </g>

    <g transform="translate(0, 240)">
      <rect width="220" height="46" rx="8" fill="#006837" stroke="{accent_color}" stroke-width="1.5"/>
      <text x="30" y="28" font-family="'Inter', system-ui, sans-serif" font-size="14" font-weight="800" fill="#ffffff" letter-spacing="0.5">REGISTER FOR SUMMIT</text>
    </g>
  </g>
</svg>'''

# -------------------------------------------------------------
# 3. SVG GENERATION FOR BLOG POSTS
# -------------------------------------------------------------

def svg_blog(title, category, read_time, theme_color="#32C5F1"):
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 480" width="100%" height="100%">
  <defs>
    <linearGradient id="bGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#052516"/>
      <stop offset="60%" stop-color="#004d27"/>
      <stop offset="100%" stop-color="#021c10"/>
    </linearGradient>
  </defs>

  <rect width="800" height="480" fill="url(#bGrad)"/>

  <!-- Geometric Flourish -->
  <g opacity="0.08" stroke="#ffffff" stroke-width="1.5" fill="none">
    <rect x="520" y="60" width="220" height="220" rx="20" transform="rotate(15 630 170)"/>
    <circle cx="630" cy="170" r="90"/>
    <circle cx="630" cy="170" r="50"/>
  </g>

  <!-- Category Badge -->
  <g transform="translate(50, 45)">
    <rect width="170" height="32" rx="16" fill="{theme_color}" fill-opacity="0.2" stroke="{theme_color}" stroke-width="1"/>
    <text x="24" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="800" fill="{theme_color}" letter-spacing="1">{category.upper()}</text>
    
    <rect x="185" y="0" width="130" height="32" rx="16" fill="#ffffff" fill-opacity="0.1"/>
    <text x="200" y="21" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="600" fill="#cbd5e1">{read_time} MIN READ</text>
  </g>

  <!-- Title & Summary -->
  <g transform="translate(50, 130)">
    <text x="0" y="38" font-family="'Inter', system-ui, sans-serif" font-size="30" font-weight="900" fill="#ffffff" width="680">{title}</text>
    
    <g transform="translate(0, 180)">
      <circle cx="24" cy="24" r="24" fill="#006837" stroke="{theme_color}" stroke-width="2"/>
      <text x="24" y="30" font-family="'Inter', system-ui, sans-serif" font-size="16" font-weight="900" fill="#ffffff" text-anchor="middle">PBZ</text>
      
      <text x="64" y="20" font-family="'Inter', system-ui, sans-serif" font-size="14" font-weight="700" fill="#ffffff">PBZ Research &amp; Regulatory Affairs</text>
      <text x="64" y="38" font-family="'Inter', system-ui, sans-serif" font-size="12" font-weight="500" fill="#94a3b8">Published by People's Bank of Zanzibar Academy</text>
    </g>
  </g>
</svg>'''

# -------------------------------------------------------------
# 4. ABOUT & CHOOSE-US ZANZIBAR THEMED GRAPHICS
# -------------------------------------------------------------

def svg_zanzibar_dhow_badge():
    return '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300" width="100%" height="100%">
  <defs>
    <linearGradient id="dhowBg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#006837"/>
      <stop offset="100%" stop-color="#32C5F1"/>
    </linearGradient>
  </defs>
  <rect width="300" height="300" rx="30" fill="url(#dhowBg)"/>
  <circle cx="150" cy="150" r="120" fill="#072818" opacity="0.85"/>
  <circle cx="150" cy="150" r="105" fill="none" stroke="#F9ED27" stroke-width="2" stroke-dasharray="6 4"/>
  
  <!-- Dhow Boat Silhouette -->
  <g transform="translate(60, 80) scale(0.6)">
    <!-- Hull -->
    <path d="M20,190 Q150,230 280,190 C260,240 60,240 20,190 Z" fill="#F9ED27"/>
    <!-- Sail -->
    <path d="M150,20 L150,190 M150,20 L50,170 L150,170 M150,40 L250,160 L150,160" fill="#ffffff" stroke="#ffffff" stroke-width="3"/>
    <!-- Waves -->
    <path d="M0,230 Q75,210 150,230 T300,230" fill="none" stroke="#32C5F1" stroke-width="4"/>
  </g>

  <text x="150" y="248" font-family="'Inter', system-ui, sans-serif" font-size="13" font-weight="800" fill="#ffffff" text-anchor="middle" letter-spacing="1.5">ZANZIBAR SOVEREIGNTY</text>
</svg>'''

def svg_clove_crest_badge():
    return '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 250 250" width="100%" height="100%">
  <defs>
    <linearGradient id="crestGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#072818"/>
      <stop offset="100%" stop-color="#004d27"/>
    </linearGradient>
  </defs>
  <rect width="250" height="250" rx="28" fill="url(#crestGrad)" stroke="#F9ED27" stroke-width="3"/>
  <circle cx="125" cy="110" r="60" fill="#0b3820" stroke="#32C5F1" stroke-width="2"/>
  
  <!-- Clove Flower Bud / Star Motif -->
  <g transform="translate(125, 110)">
    <!-- 4 Clove calyx petals -->
    <path d="M0,0 C-15,-20 -25,-10 -25,0 C-25,10 -15,20 0,0" fill="#F9ED27"/>
    <path d="M0,0 C15,-20 25,-10 25,0 C25,10 15,20 0,0" fill="#F9ED27"/>
    <path d="M0,0 C-20,-15 -10,-25 0,-25 C10,-25 20,-15 0,0" fill="#F9ED27"/>
    <path d="M0,0 C-20,15 -10,25 0,25 C10,25 20,15 0,0" fill="#F9ED27"/>
    <circle cx="0" cy="0" r="14" fill="#ffffff"/>
    <circle cx="0" cy="0" r="8" fill="#006837"/>
  </g>

  <text x="125" y="195" font-family="'Inter', system-ui, sans-serif" font-size="14" font-weight="800" fill="#ffffff" text-anchor="middle">PBZ HERITAGE</text>
  <text x="125" y="215" font-family="'Inter', system-ui, sans-serif" font-size="11" font-weight="600" fill="#32C5F1" text-anchor="middle">ESTABLISHED 1966</text>
</svg>'''

# -------------------------------------------------------------
# MAIN WRITING LOGIC
# -------------------------------------------------------------

def main():
    base_dir = '/Applications/MAMP/htdocs/pbzlms'
    
    # 1. Courses
    courses = {
        'aml-cft': svg_course_aml(),
        'amana-islamic': svg_course_islamic(),
        'cyber-hygiene': svg_course_cyber(),
    }
    for name, svg in courses.items():
        path = f'{base_dir}/public/storage/courses/{name}.svg'
        ensure_dir(path)
        with open(path, 'w') as f:
            f.write(svg)
        print(f'Wrote {path}')

    # 2. Events
    events = {
        'bot-summit-2026': svg_event('PBZ Annual BOT Compliance Summit 2026', 'Executive Regulatory Directives & Audit Readiness', 'PBZ LEADERSHIP', 'Nov 12 - 14, 2026', 'Golden Tulip Grand Ballroom, Zanzibar', 'bot'),
        'islamic-fintech-forum': svg_event('East Africa Islamic Banking Forum', 'Shariah Digital Governance & Amana Innovations', 'PBZ AMANA', 'Dec 05 - 07, 2026', 'Zanzibar Serena Hotel Waterfront', 'islamic'),
        'cyber-defense-workshop': svg_event('PBZ Cyber Defense & Threat Simulation', 'Zero-Trust Operations & Ransomware Countermeasures', 'PBZ INFOSEC', 'Oct 28 - 29, 2026', 'PBZ Head Office Training Centre, Mpirani', 'cyber'),
        'wakala-rollout-forum': svg_event('PBZ Wakala Agent Banking Forum', 'Expanding Financial Inclusion across Unguja & Pemba', 'RETAIL BANKING', 'Jan 18, 2027', 'Stone Town Convention Centre', 'bot'),
    }
    for name, svg in events.items():
        path = f'{base_dir}/public/storage/events/{name}.svg'
        ensure_dir(path)
        with open(path, 'w') as f:
            f.write(svg)
        print(f'Wrote {path}')

    # 3. Blogs
    blogs = {
        'bot-aml-guidelines-2026': svg_blog('Bank of Tanzania (BOT) 2026 Directives: Enhancing Risk-Based AML Screening for Commercial Banks', 'Regulatory Compliance', 6, '#32C5F1'),
        'rise-of-pbz-amana-islamic-banking': svg_blog('The Expansion of PBZ Amana: How Shariah-Compliant Banking is Driving Financial Inclusion in Zanzibar', 'Islamic Banking', 8, '#F9ED27'),
        'zero-trust-core-banking-security': svg_blog('Zero-Trust Architecture in Core Banking: Strengthening PBZ Infrastructure Against Advanced Cyber Threats', 'Cybersecurity', 7, '#00FF88'),
        'modernizing-branch-microlearning': svg_blog('Transforming 34 Branches with Micro-Learning: Zero Teller Disruption and Measurable Compliance', 'Human Capital', 5, '#32C5F1'),
        'financing-zanzibar-blue-economy': svg_blog('Trade Finance & The Blue Economy: Financing Zanzibar Maritime, Fisheries and Clove Export Chains', 'Trade Finance', 9, '#F9ED27'),
        'digital-onboarding-pbz-wakala': svg_blog('Next-Generation Customer Onboarding: Unifying Mobile Banking & PBZ Wakala Nationwide Points', 'Digital Banking', 6, '#32C5F1'),
    }
    for name, svg in blogs.items():
        path = f'{base_dir}/public/storage/blogs/{name}.svg'
        ensure_dir(path)
        with open(path, 'w') as f:
            f.write(svg)
        print(f'Wrote {path}')

    # 4. About & Choose-us badges
    about_badges = {
        'about-02.png': svg_clove_crest_badge(),
        'about-03.png': svg_zanzibar_dhow_badge(),
        'choose-2.png': svg_clove_crest_badge(),
        'choose-3.png': svg_zanzibar_dhow_badge(),
    }
    for name, svg in about_badges.items():
        # save as svg
        svg_path = f'{base_dir}/public/storage/branding/{name}.svg'
        ensure_dir(svg_path)
        with open(svg_path, 'w') as f:
            f.write(svg)
        print(f'Wrote {svg_path}')

if __name__ == '__main__':
    main()

#!/usr/bin/env python3
"""
Generate and overwrite all PBZ visual assets:
- Hero images (Zanzibari male & female bankers, African professional avatars)
- About & Choose-Us visuals (PBZ Academy Boardroom, Clove heritage crest, Zanzibar Dhow boat)
- CPD Portal background (Rich PBZ green/navy banking gradient with Stone Town / Islamic motifs)
- Admin Theme Preview Mockup: public/assets/admin/img/default.png (1920x883)
- Admin Eduna Theme Preview Mockup: public/themes/eduna/screenshot.png (2032x1116)
"""

import os
from PIL import Image, ImageDraw, ImageOps, ImageFilter, ImageFont

BASE_DIR = '/Applications/MAMP/htdocs/pbzlms'
SOURCE_DIR = '/Users/apple/.gemini/antigravity-ide/brain/f5fc9f03-3340-49a2-96a3-97f60a7f4be8'

p_male = f'{SOURCE_DIR}/zanzibar_banker_hero_1792031983661.jpg'
p_female = f'{SOURCE_DIR}/zanzibar_female_banker_1792032010270.jpg'
p_academy = f'{SOURCE_DIR}/zanzibar_banking_academy_1792032043229.jpg'

im_male = Image.open(p_male)
im_female = Image.open(p_female)
im_academy = Image.open(p_academy)

def ensure_parent(p):
    os.makedirs(os.path.dirname(p), exist_ok=True)

# -------------------------------------------------------------
# 1. HERO IMAGES (Pill / Arched Frames)
# -------------------------------------------------------------
def make_pill_frame(im, w, h, radius=None, border_color=(50, 197, 241, 255), border_width=4, center=(0.5, 0.3)):
    fit_im = ImageOps.fit(im, (w, h), centering=center).convert('RGBA')
    if radius is None:
        radius = int(min(w, h) * 0.45)
    
    mask = Image.new('L', (w, h), 0)
    d = ImageDraw.Draw(mask)
    d.rounded_rectangle([0, 0, w - 1, h - 1], radius=radius, fill=255)
    
    # Draw subtle inner glow / border
    border_layer = Image.new('RGBA', (w, h), (0, 0, 0, 0))
    db = ImageDraw.Draw(border_layer)
    db.rounded_rectangle([0, 0, w - 1, h - 1], radius=radius, outline=border_color, width=border_width)
    
    out = fit_im.copy()
    out.putalpha(mask)
    out = Image.alpha_composite(out, border_layer)
    return out

# 1a. Male Banker (hero-02: 342 x 576)
hero_male = make_pill_frame(im_male, 342, 576, radius=160, border_color=(50, 197, 241, 255), border_width=4, center=(0.5, 0.22))
# 1b. Female Banker (hero-01: 272 x 465)
hero_female = make_pill_frame(im_female, 272, 465, radius=130, border_color=(0, 104, 55, 255), border_width=4, center=(0.52, 0.35))

# Save both as new files AND overwrite legacy
hero_paths_male = [
    f'{BASE_DIR}/public/assets/front/img/home-1/hero/pbz-hero-male.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/hero/hero-02.png',
    f'{BASE_DIR}/public/assets/front/img/home-2/hero/hero-02.png',
]
hero_paths_female = [
    f'{BASE_DIR}/public/assets/front/img/home-1/hero/pbz-hero-female.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/hero/hero-01.png',
    f'{BASE_DIR}/public/assets/front/img/home-2/hero/hero-01.png',
]

for p in hero_paths_male:
    ensure_parent(p)
    hero_male.save(p, 'PNG')
    print(f'Saved: {p}')

for p in hero_paths_female:
    ensure_parent(p)
    hero_female.save(p, 'PNG')
    print(f'Saved: {p}')

# 1c. Student Avatars Pill (client-img.png: 202 x 53)
avatar_pile = Image.new('RGBA', (202, 53), (0, 0, 0, 0))
a1 = ImageOps.fit(im_male, (48, 48), centering=(0.5, 0.22))
a2 = ImageOps.fit(im_female, (48, 48), centering=(0.52, 0.35))
# Circular mask with white border
c_mask = Image.new('L', (48, 48), 0)
ImageDraw.Draw(c_mask).ellipse([0, 0, 47, 47], fill=255)
c_border = Image.new('RGBA', (48, 48), (0, 0, 0, 0))
ImageDraw.Draw(c_border).ellipse([0, 0, 47, 47], outline=(255, 255, 255, 255), width=3)

def make_circ_avatar(photo, center):
    fit = ImageOps.fit(photo, (48, 48), centering=center).convert('RGBA')
    fit.putalpha(c_mask)
    return Image.alpha_composite(fit, c_border)

c1 = make_circ_avatar(im_male, (0.5, 0.22))
c2 = make_circ_avatar(im_female, (0.52, 0.35))
c3 = make_circ_avatar(im_male, (0.5, 0.25))

avatar_pile.paste(c1, (0, 2), c1)
avatar_pile.paste(c2, (38, 2), c2)
avatar_pile.paste(c3, (76, 2), c3)

avatar_paths = [
    f'{BASE_DIR}/public/assets/front/img/home-1/hero/pbz-client-avatars.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/hero/client-img.png',
]
for p in avatar_paths:
    ensure_parent(p)
    avatar_pile.save(p, 'PNG')
    print(f'Saved: {p}')


# -------------------------------------------------------------
# 2. ABOUT & CHOOSE-US VISUALS
# -------------------------------------------------------------
# 2a. Boardroom (570 x 570, rounded rectangle)
boardroom_circle = make_pill_frame(im_academy, 570, 570, radius=285, border_color=(0, 104, 55, 255), border_width=6, center=(0.5, 0.45))
about_paths_01 = [
    f'{BASE_DIR}/public/assets/front/img/home-1/about/pbz-about-boardroom.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/about/about-01.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/choose-us/pbz-choose-academy.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/choose-us/choose-1.png',
    f'{BASE_DIR}/public/assets/front/img/home-2/about/about-left-img.png',
    f'{BASE_DIR}/public/assets/front/img/home-3/about/about-01.png',
]
for p in about_paths_01:
    ensure_parent(p)
    boardroom_circle.save(p, 'PNG')
    print(f'Saved: {p}')

# 2b. Clove Spice Heritage Badge (250 x 250, circle)
def make_clove_circle(size=250):
    im = Image.new('RGBA', (size, size), (0, 0, 0, 0))
    d = ImageDraw.Draw(im)
    # Circle base
    d.ellipse([0, 0, size - 1, size - 1], fill=(7, 40, 24, 255), outline=(249, 237, 39, 255), width=6)
    cx, cy = size // 2, size // 2
    r = int(size * 0.38)
    d.ellipse([cx - r, cy - r, cx + r, cy + r], fill=(11, 56, 32, 255), outline=(50, 197, 241, 255), width=3)
    # 4 golden clove buds
    pr = int(r * 0.6)
    d.ellipse([cx - pr, cy - pr, cx + pr, cy + pr], fill=(249, 237, 39, 255))
    d.ellipse([cx - int(pr * 0.45), cy - int(pr * 0.45), cx + int(pr * 0.45), cy + int(pr * 0.45)], fill=(0, 104, 55, 255))
    return im

clove_img = make_clove_circle(250)
clove_paths = [
    f'{BASE_DIR}/public/assets/front/img/home-1/about/pbz-about-clove.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/about/about-02.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/choose-us/pbz-choose-clove.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/choose-us/choose-2.png',
    f'{BASE_DIR}/public/assets/front/img/home-3/about/about-02.png',
]
for p in clove_paths:
    ensure_parent(p)
    clove_img.save(p, 'PNG')
    print(f'Saved: {p}')

# 2c. Zanzibar Dhow Sailing Badge (300 x 300, circle)
def make_dhow_circle(size=300):
    im = Image.new('RGBA', (size, size), (0, 0, 0, 0))
    d = ImageDraw.Draw(im)
    d.ellipse([0, 0, size - 1, size - 1], fill=(0, 104, 55, 255), outline=(50, 197, 241, 255), width=6)
    cx, cy = size // 2, size // 2
    r = int(size * 0.38)
    d.ellipse([cx - r, cy - r, cx + r, cy + r], fill=(7, 40, 24, 255), outline=(249, 237, 39, 255), width=3)
    # Dhow boat hull
    hx, hy = cx, int(cy * 1.15)
    d.chord([hx - int(r * 0.65), hy - int(r * 0.25), hx + int(r * 0.65), hy + int(r * 0.4)], start=0, end=180, fill=(249, 237, 39, 255))
    # Dhow sails
    d.polygon([(hx, hy - int(r * 0.75)), (hx, hy), (hx - int(r * 0.5), hy - int(r * 0.1))], fill=(255, 255, 255, 240))
    d.polygon([(hx + 2, hy - int(r * 0.65)), (hx + 2, hy), (hx + int(r * 0.45), hy - int(r * 0.1))], fill=(255, 255, 255, 200))
    return im

dhow_img = make_dhow_circle(300)
dhow_paths = [
    f'{BASE_DIR}/public/assets/front/img/home-1/about/pbz-about-dhow.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/about/about-03.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/choose-us/pbz-choose-dhow.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/choose-us/choose-3.png',
]
for p in dhow_paths:
    ensure_parent(p)
    dhow_img.save(p, 'PNG')
    print(f'Saved: {p}')

# 2d. Author Headshot (Dean Amina Khamis Salim: 120 x 120)
author_img = ImageOps.fit(im_female, (120, 120), centering=(0.52, 0.35))
author_mask = Image.new('L', (120, 120), 0)
ImageDraw.Draw(author_mask).ellipse([0, 0, 119, 119], fill=255)
author_out = author_img.convert('RGBA')
author_out.putalpha(author_mask)
author_paths = [
    f'{BASE_DIR}/public/assets/front/img/home-1/about/pbz-dean-amina.png',
    f'{BASE_DIR}/public/assets/front/img/home-1/about/client-01.png',
]
for p in author_paths:
    ensure_parent(p)
    author_out.save(p, 'PNG')
    print(f'Saved: {p}')

# -------------------------------------------------------------
# 3. CPD PORTAL BANNER (discount/bg-img.jpg: 1920 x 600)
# -------------------------------------------------------------
def make_cpd_banner(w=1920, h=600):
    im = Image.new('RGB', (w, h), (7, 40, 24))
    d = ImageDraw.Draw(im)
    # Rich gradient background
    for y in range(h):
        r = int(7 + (0 - 7) * (y / h))
        g = int(40 + (104 - 40) * (y / h))
        b = int(24 + (55 - 24) * (y / h))
        d.line([(0, y), (w, y)], fill=(r, g, b))
    
    # Subtle geometric grid / Islamic arch silhouettes
    for x in range(0, w, 120):
        d.line([(x, 0), (x, h)], fill=(50, 197, 241), width=1)
    
    # Soft right-side silhouette of banking boardroom
    acad_fit = ImageOps.fit(im_academy, (800, h), centering=(0.5, 0.5)).convert('RGBA')
    # Soft linear alpha mask
    fade = Image.new('L', (800, h), 0)
    for fx in range(800):
        val = int(255 * (fx / 800) * 0.45)
        for fy in range(h):
            fade.putpixel((fx, fy), val)
    acad_fit.putalpha(fade)
    
    im.paste(acad_fit, (w - 800, 0), acad_fit)
    return im

cpd_bg = make_cpd_banner()
cpd_paths = [
    f'{BASE_DIR}/public/assets/front/img/home-1/discount/pbz-cpd-bg.jpg',
    f'{BASE_DIR}/public/assets/front/img/home-1/discount/bg-img.jpg',
]
for p in cpd_paths:
    ensure_parent(p)
    cpd_bg.save(p, 'JPEG', quality=92)
    print(f'Saved: {p}')


# -------------------------------------------------------------
# 4. ADMIN THEME PREVIEWS
# -------------------------------------------------------------
# 4a. Default Theme Cover: public/assets/admin/img/default.png (1920 x 883)
def make_admin_default_cover():
    w, h = 1920, 883
    im = Image.new('RGB', (w, h), (248, 250, 252))
    d = ImageDraw.Draw(im)
    
    # Browser chrome header
    d.rectangle([0, 0, w, 44], fill=(226, 232, 240))
    # Red, yellow, green buttons
    d.ellipse([16, 16, 28, 28], fill=(239, 68, 68))
    d.ellipse([36, 16, 48, 48], fill=(245, 158, 11))
    d.ellipse([56, 16, 68, 68], fill=(34, 197, 94))
    # Address bar
    d.rounded_rectangle([120, 10, w - 120, 34], radius=6, fill=(255, 255, 255))
    
    # Top Banking Navbar (PBZ Green)
    d.rectangle([0, 44, w, 110], fill=(0, 104, 55))
    
    # Paste PBZ Logo
    logo_path = f'{BASE_DIR}/public/assets/front/img/logo/pbz-logo.png'
    if os.path.exists(logo_path):
        pbz_l = Image.open(logo_path).convert('RGBA')
        pbz_l_fit = ImageOps.contain(pbz_l, (200, 52))
        im.paste(pbz_l_fit, (50, 51), pbz_l_fit)
    
    # Hero Section Gradient Background
    for y in range(110, 580):
        t = (y - 110) / 470
        r = int(240 + (224 - 240) * t)
        g = int(248 + (242 - 248) * t)
        b = int(245 + (235 - 245) * t)
        d.line([(0, y), (w, y)], fill=(r, g, b))
    
    # Left Hero Text Boxes (Simulated high-res UI)
    d.rounded_rectangle([80, 160, 360, 192], radius=16, fill=(0, 104, 55, 40))
    # Big Headline Bars
    d.rounded_rectangle([80, 220, 780, 265], radius=6, fill=(15, 23, 42))
    d.rounded_rectangle([80, 280, 720, 325], radius=6, fill=(15, 23, 42))
    d.rounded_rectangle([80, 340, 560, 375], radius=6, fill=(0, 104, 55))
    # CTA Button
    d.rounded_rectangle([80, 420, 280, 470], radius=8, fill=(0, 104, 55))
    
    # Right Hero Images
    hero_f_thumb = ImageOps.fit(im_female, (300, 420), centering=(0.52, 0.35)).convert('RGBA')
    f_mask = Image.new('L', (300, 420), 0)
    ImageDraw.Draw(f_mask).rounded_rectangle([0, 0, 299, 419], radius=120, fill=255)
    hero_f_thumb.putalpha(f_mask)
    im.paste(hero_f_thumb, (940, 140), hero_f_thumb)
    
    hero_m_thumb = ImageOps.fit(im_male, (340, 460), centering=(0.5, 0.22)).convert('RGBA')
    m_mask = Image.new('L', (340, 460), 0)
    ImageDraw.Draw(m_mask).rounded_rectangle([0, 0, 339, 459], radius=140, fill=255)
    hero_m_thumb.putalpha(m_mask)
    im.paste(hero_m_thumb, (1260, 120), hero_m_thumb)
    
    # 3 Bottom Course Cards (AML, Amana, Cyber)
    card_w = (w - 160 - 60) // 3
    y_card = 600
    card_h = 250
    for i in range(3):
        xc = 80 + i * (card_w + 30)
        d.rounded_rectangle([xc, y_card, xc + card_w, y_card + card_h], radius=12, fill=(255, 255, 255), outline=(226, 232, 240), width=2)
        # Card header img
        d.rounded_rectangle([xc, y_card, xc + card_w, y_card + 110], radius=12, fill=(7, 40, 24))
        # Title bar
        d.rounded_rectangle([xc + 20, y_card + 130, xc + card_w - 40, y_card + 150], radius=4, fill=(15, 23, 42))
        d.rounded_rectangle([xc + 20, y_card + 160, xc + card_w - 90, y_card + 175], radius=4, fill=(100, 116, 139))
        d.rounded_rectangle([xc + 20, y_card + 195, xc + 140, y_card + 225], radius=6, fill=(0, 104, 55))
    
    return im

admin_default = make_admin_default_cover()
admin_default_path = f'{BASE_DIR}/public/assets/admin/img/default.png'
admin_default.save(admin_default_path, 'PNG')
print(f'Saved: {admin_default_path}')

# 4b. Eduna Theme Cover: public/themes/eduna/screenshot.png (2032 x 1116)
def make_admin_eduna_cover():
    w, h = 2032, 1116
    im = Image.new('RGB', (w, h), (7, 40, 24))
    d = ImageDraw.Draw(im)
    
    # Islamic Arabesque Gold Gradient Header
    for y in range(h):
        t = y / h
        r = int(7 + (0 - 7) * t)
        g = int(40 + (80 - 40) * t)
        b = int(24 + (45 - 24) * t)
        d.line([(0, y), (w, y)], fill=(r, g, b))
    
    # Elegant gold framing
    d.rectangle([30, 30, w - 30, h - 30], outline=(249, 237, 39), width=3)
    d.rectangle([45, 45, w - 45, h - 45], outline=(50, 197, 241), width=1)
    
    # Boardroom and Bankers Showcase
    acad_thumb = ImageOps.fit(im_academy, (700, 520), centering=(0.5, 0.45)).convert('RGBA')
    im.paste(acad_thumb, (1200, 220))
    
    male_thumb = ImageOps.fit(im_male, (400, 520), centering=(0.5, 0.22)).convert('RGBA')
    im.paste(male_thumb, (150, 220))
    
    female_thumb = ImageOps.fit(im_female, (400, 520), centering=(0.52, 0.35)).convert('RGBA')
    im.paste(female_thumb, (600, 220))
    
    return im

admin_eduna = make_admin_eduna_cover()
admin_eduna_path = f'{BASE_DIR}/public/themes/eduna/screenshot.png'
ensure_parent(admin_eduna_path)
admin_eduna.save(admin_eduna_path, 'PNG')
print(f'Saved: {admin_eduna_path}')

print('All PBZ image assets and admin theme covers successfully generated!')

<?php

namespace Database\Seeders;

use App\Models\FrontendSetting;
use Illuminate\Database\Seeder;

class FrontendSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FrontendSetting::setValue('footer.branding', [
            'about_text' => 'The People\'s Bank of Zanzibar (PBZ) Learning Management System delivers accredited banking certifications, BOT statutory compliance, AML/CFT training, and Islamic finance curricula.',
            'tagline' => 'Bank of Tanzania Certified Digital Academy',
            'copyright' => '© ' . date('Y') . ' The People\'s Bank of Zanzibar (PBZ). All rights reserved.',
        ]);

        FrontendSetting::setValue('footer.contact', [
            'email' => 'lms@pbzbank.co.tz',
            'phone' => '+255 24 223 1118',
            'address' => 'Mizingani Road, P.O. Box 1173, Zanzibar, Tanzania',
            'hours' => 'Mon - Fri: 8:30am - 4:30pm EAT',
        ]);

        FrontendSetting::setValue('footer.social_links', [
            [
                'label' => 'Follow on Facebook',
                'url' => 'https://facebook.com/pbzbank',
                'icon' => 'fab fa-facebook-f',
            ],
            [
                'label' => 'Follow on Twitter',
                'url' => 'https://twitter.com/pbzbank',
                'icon' => 'fab fa-twitter',
            ],
            [
                'label' => 'Connect on LinkedIn',
                'url' => 'https://linkedin.com/company/pbzbank',
                'icon' => 'fab fa-linkedin-in',
            ],
        ]);

        FrontendSetting::setValue('pages.faq.items', [
            [
                'question' => 'What courses do you offer?',
                'answer' => '<p>We provide a comprehensive catalog covering Bank of Tanzania (BOT) statutory compliance, AML/CFT prevention, Amana Islamic Banking, retail banking operations, credit appraisal, and digital financial systems.</p>',
            ],
            [
                'question' => 'Can I learn at my own pace?',
                'answer' => '<p>Yes. All on-demand courses are self-paced with micro-learning modules so banking staff can study while managing daily branch duties.</p>',
            ],
            [
                'question' => 'Do you offer certificates of completion?',
                'answer' => '<p>Every accredited course awards an official, verifiable PBZ Digital Certificate upon successfully passing the compliance assessment.</p>',
            ],
            [
                'question' => 'How can I get support if I have questions?',
                'answer' => '<p>You can reach our learning operations team anytime via email or internal portal tickets. Senior compliance officers and faculty mentors are also available for consultation.</p>',
            ],
        ]);

        FrontendSetting::setValue('pages.seo.meta', [
            'home' => [
                'title' => 'PBZ Learning Academy',
                'description' => 'Official People\'s Bank of Zanzibar (PBZ) Digital Learning Academy. Bank of Tanzania statutory certifications, AML/CFT compliance, and Islamic banking curricula.',
            ],
            'courses' => [
                'title' => 'Banking Certifications & Courses',
                'description' => 'Explore PBZ accredited banking programs covering central bank regulations, risk management, trade finance, customer service, and digital banking.',
            ],
            'faq' => [
                'title' => 'Frequently Asked Questions',
                'description' => 'Find answers to popular questions about PBZ banking curricula, BOT certifications, exams, grading, and faculty support.',
            ],
            'about' => [
                'title' => 'About PBZ Academy',
                'description' => 'Learn about People\'s Bank of Zanzibar (PBZ) mission, banking workforce development, and BOT compliance standards.',
            ],
            'events' => [
                'title' => 'Upcoming Compliance Seminars & Workshops',
                'description' => 'Explore upcoming PBZ banking webinars, regulatory roundtables, and live workshops.',
            ],
            'instructors' => [
                'title' => 'PBZ Certified Faculty & Mentors',
                'description' => 'Meet experienced senior bankers, risk specialists, and regulatory compliance mentors at PBZ.',
            ],
            'contact' => [
                'title' => 'Contact PBZ Academy Support',
                'description' => 'Need assistance with course enrollment or certification? Contact PBZ Learning Academy support desk.',
            ],
            'blog' => [
                'title' => 'Banking Insights & Regulatory Bulletins',
                'description' => 'Stay informed with PBZ banking articles, Bank of Tanzania regulatory updates, and modern financial sector insights.',
            ],
            'testimonials' => [
                'title' => 'Banker Testimonials',
                'description' => 'Read reviews and career milestones from certified PBZ staff, branch managers, and banking trainees.',
            ],
            'privacy-policy' => [
                'title' => 'Privacy Policy',
                'description' => 'Learn how People\'s Bank of Zanzibar safeguards trainee data and banking records under statutory confidentiality standards.',
            ],
            'terms-and-conditions' => [
                'title' => 'Terms of Service',
                'description' => 'Review the official terms of service and code of ethics for the PBZ Learning Management System.',
            ],
            'gdpr-compliance' => [
                'title' => 'Data Protection & Compliance',
                'description' => 'Information on PBZ data protection practices adhering to Tanzanian banking laws and international security standards.',
            ],
        ]);

        FrontendSetting::setValue('pages.marquee.items', [
            [
                'image' => 'assets/front/img/home-1/icon1.png',
                'text' => 'Education & University',
            ],
            [
                'image' => 'assets/front/img/home-1/icon1.png',
                'text' => 'Online Education',
            ],
            [
                'image' => 'assets/front/img/home-1/icon1.png',
                'text' => '230+ Quality Courses',
            ],
            [
                'image' => 'assets/front/img/home-1/icon1.png',
                'text' => 'Experienced Instructors',
            ],
            [
                'image' => 'assets/front/img/home-1/icon1.png',
                'text' => '25% Extra Coupon Bonus',
            ],
        ]);

        FrontendSetting::setValue('pages.contact.hero', [
            'eyebrow' => 'Need Any Help?',
            'heading' => 'Get in touch with us',
            'description' => 'Our support team is here to help you choose the right course, solve account issues, and keep your learning on track. Reach out and we will get back to you within one business day.',
        ]);

        FrontendSetting::setValue('pages.contact.methods', [
            [
                'icon' => 'fa-light fa-phone',
                'label' => 'Call us anytime',
                'type' => 'phone',
                'value' => '+1 (800) 555-1234',
            ],
            [
                'icon' => 'fa-light fa-envelope',
                'label' => 'Send us an email',
                'type' => 'email',
                'value' => 'lms@pbzbank.co.tz',
            ],
            [
                'icon' => 'fa-light fa-location-dot',
                'label' => 'Visit our academy',
                'type' => 'address',
                'value' => 'Mizingani Road, P.O. Box 1173, Zanzibar, Tanzania',
            ],
            [
                'icon' => 'fa-light fa-clock',
                'label' => 'Support hours',
                'type' => 'hours',
                'value' => 'Mon - Fri: 8:30am - 4:30pm EAT',
            ],
        ]);

        FrontendSetting::setValue('pages.contact.form', [
            'heading' => 'Send us a message',
            'description' => 'Let us know how we can help with your learning journey. Our academy support team responds within one business day.',
            'submit_label' => 'Send Message',
            'success_message' => 'Thank you for contacting PBZ Academy. We will reach out shortly!',
            'subject_prefix' => '[PBZ Academy Support]',
        ]);

        FrontendSetting::setValue('pages.contact.map', [
            'embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.062828551381!2d39.1878342!3d-6.1600155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185cd05a396b27db%3A0xb36d80ff632e85ab!2sPeople%27s%20Bank%20of%20Zanzibar!5e0!3m2!1sen!2stz!4v1700000000000!5m2!1sen!2stz',
            'caption' => 'PBZ Head Office, Mizingani Road, Stone Town, Zanzibar, Tanzania.',
        ]);

        FrontendSetting::setValue('pages.home.hero', [
            'preheading' => 'Sovereign Banking Learning Platform',
            'heading' => 'Master Central Bank Compliance & Digital Banking',
            'description' => 'Official corporate learning academy of The People\'s Bank of Zanzibar. Bank of Tanzania statutory certifications, AML/CFT risk management, and Amana Islamic Banking.',
            'cta_label' => 'Explore Courses',
            'cta_url' => route('courses'),
        ]);

        FrontendSetting::setValue('pages.home.testimonial', [
            'title' => 'Trainee Reviews',
            'subtitle' => 'What PBZ banking staff say about the academy',
            'cta_label' => 'All Testimonials',
            'cta_url' => route('testimonials.index'),
        ]);

        FrontendSetting::setValue('pages.home.blog', [
            'title' => 'Banking Bulletins',
            'subtitle' => 'Insights from PBZ compliance officers & industry specialists',
            'description' => 'Stay updated with regulatory circulars, course milestones, and financial trends from across the PBZ banking network.',
        ]);

        FrontendSetting::setValue('pages.home.about', [
            'subheading' => 'About PBZ Academy',
            'heading' => 'Advancing Excellence in Tanzanian Banking',
            'description' => 'We deliver structured learning pathways designed to uphold the highest regulatory, operational, and customer service standards across Zanzibar and mainland Tanzania.',
            'cta_label' => 'Learn More',
            'cta_url' => route('about'),
            'author_name' => 'Renatus Bernardo',
            'author_title' => 'Chief Learning Officer',
        ]);

        FrontendSetting::setValue('pages.home.discount', [
            'heading' => 'Enroll in Q4 Mandatory Compliance Modules Today',
            'description' => 'All PBZ branch personnel and head office departments must complete updated Anti-Money Laundering (AML) and Counter-Terrorist Financing (CFT) modules.',
            'primary_label' => 'Staff Sign In',
            'primary_url' => route('login'),
            'secondary_label' => 'Faculty Portal',
            'secondary_url' => route('instructor.login'),
        ]);

        FrontendSetting::setValue('pages.home.features', [
            'title' => 'Why Learn With Us',
            'subtitle' => 'Institutional Quality Tailored to Banking Regulations.',
            'description' => 'Continuous professional development aligned with Bank of Tanzania supervisory requirements and international banking best practices.',
            'highlight_count' => 100,
            'highlight_label' => 'BOT Compliant Modules.',
            'items' => [
                [
                    'icon' => 'fa-solid fa-shield-halved',
                    'title' => 'Regulatory Compliance',
                    'description' => 'Bank of Tanzania statutory compliance, AML/CFT audits, and KYC verification standards.',
                ],
                [
                    'icon' => 'fa-solid fa-moon',
                    'title' => 'Islamic Finance',
                    'description' => 'PBZ Ikhlas Sharia-compliant banking principles, Murabaha, and Ijara governance.',
                ],
                [
                    'icon' => 'fa-solid fa-vault',
                    'title' => 'Branch & Retail Operations',
                    'description' => 'Cash handling, teller operations, credit risk analysis, and customer service.',
                ],
                [
                    'icon' => 'fa-solid fa-chart-line',
                    'title' => 'Treasury & Risk',
                    'description' => 'Liquidity management, foreign exchange dealing, and operational risk mitigation.',
                ],
            ],
        ]);

        FrontendSetting::setValue('pages.home.cta', [
            'heading' => 'Stay updated with internal training circulars.',
            'description' => 'Receive direct notifications on regulatory deadlines, new course modules, and faculty office hours.',
            'placeholder' => 'Enter your official PBZ email',
            'button_label' => 'Subscribe',
        ]);

        FrontendSetting::setValue('pages.about.hero', [
            'subheading' => 'About Us',
            'heading' => 'Transforming Banking Competency Into Lasting Impact',
            'description' => 'PBZ Learning Academy is the dedicated workforce training institution for The People\'s Bank of Zanzibar, powering continuous regulatory and technical banking development.',
            'cta_label' => 'Explore Courses',
            'cta_url' => route('courses'),
            'author_name' => 'PBZ Academy Faculty',
            'author_title' => 'Excellence in Banking Education',
        ]);

        FrontendSetting::setValue('pages.about.features', [
            'title' => 'Why Choose Us',
            'subtitle' => 'Learning that aligns with your personal goals.',
            'description' => 'Unlock your full potential with education tailored to your aspirations. We help learners develop practical skills, stay ahead of industry trends, and build confidence.',
            'items' => [
                [
                    'icon' => 'fa-solid fa-check-circle',
                    'text' => 'Flexible classes that fit your schedule.',
                ],
                [
                    'icon' => 'fa-solid fa-globe',
                    'text' => 'Learn anywhere, across devices.',
                ],
                [
                    'icon' => 'fa-solid fa-headset',
                    'text' => 'Dedicated support & resources.',
                ],
            ],
        ]);

        FrontendSetting::setValue('pages.about.highlights', [
            'left' => [
                [
                    'icon' => 'fa-solid fa-graduation-cap',
                    'count' => '24/7',
                    'label' => 'Learning Resources',
                ],
                [
                    'icon' => 'fa-solid fa-people-group',
                    'count' => '100%',
                    'label' => 'Community Support',
                ],
            ],
            'right' => [
                [
                    'icon' => 'fa-solid fa-briefcase',
                    'count' => 0,
                    'label' => 'Career Pathways',
                ],
            ],
        ]);

        FrontendSetting::setValue('pages.about.cta', [
            'heading' => 'Start your learning journey today.',
            'description' => 'Find the perfect course, connect with expert instructors, and build the skills you need to grow.',
            'primary_label' => 'Browse Courses',
            'primary_url' => route('courses'),
            'secondary_label' => 'Meet Our Teachers',
            'secondary_url' => route('instructors.index'),
        ]);
    }
}

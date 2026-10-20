# People's Bank of Zanzibar (PBZ) Learning Management System
## Enterprise Platform Features and Capabilities Specification

---

### Executive Overview

The People's Bank of Zanzibar (PBZ) Learning Management System (LMS) is an enterprise-grade digital academy platform engineered to deliver compliance training, professional banking certifications, continuing professional development (CPD), and institutional knowledge transfer across retail, corporate, Islamic banking, risk management, and regulatory compliance domains.

Built upon a robust, scalable architecture using PHP 8.3 and modern Laravel, the platform integrates granular role-based governance (RBAC), multi-channel payment processing, interactive learning players, automated assessment workflows, drag-and-drop certificate authoring, the Bank of Tanzania (BOT) Compliance Engine with Branch Oversight Matrix, and advanced pedagogical tools.

---

### System Architecture and Foundation

* **Core Framework:** Laravel 11/12 on PHP 8.3 with MySQL relational database storage.
* **Rendering Engine:** Server-rendered Blade architecture paired with unified vanilla CSS design systems, TailwindCSS utility integration, and responsive viewport optimization.
* **Corporate Design System:** Unified banking color palette utilizing PBZ Deep Navy (`#0a2540`), PBZ Amber Gold (`#f59e0b`), Emerald (`#10b981`), and Deep Submarine Slate (`#0f172a`), with clean SaaS typography (Inter/Outfit) and shared layout tokens across all portal views.
* **Role-Based Access Control (RBAC) & Indirection Layer:** Multi-guard authorization engine built upon Spatie Laravel-Permission combined with custom Gate definitions. Granular capabilities (`instructor:create`, `instructor:update`, `instructor:delete`, `student:create`, `student:update`, `student:delete`) decouple permissions from hardcoded role strings.
* **Defense-in-Depth & Self-Deletion Protection:** Dual-tier authorization enforcement at both the HTTP route boundary (`can:...` middleware) and controller action layer (`Gate::authorize()`). Built-in veto interceptors strictly prevent administrators from deleting their own active accounts.
* **Document and Media Processing:** DomPDF integration for high-fidelity vector PDF generation (Certificates, Event Tickets, Transcripts), native HTML5 media streaming, and secure cloud/local asset storage.
* **Authentication and Security:** Multi-guard RBAC, CSRF tokens, strict session fixation protection, SQL injection prevention via prepared PDO bindings, secure password hashing (Bcrypt/Argon2id), and administrative impersonation capabilities.
* **Payment Gateways Supported:** Stripe, PayPal, Paystack, Flutterwave, SSLCommerz, Mollie, bKash, xPay, and Manual Offline Bank Transfers with administrative clearance workflows.

---

### 1. Student Portal and Learning Experience

The Student Portal provides banking professionals and external learners with an intuitive, self-paced, and interactive learning environment.

#### 1.1 Dashboard and Learning Overview
* **Personalized Learning Metrics:** Real-time visibility into enrolled courses, active learning hours, completed modules, and earned certificates.
* **Continuing Education Progress:** Quick-resume capability directing learners to their exact last-viewed lesson.
* **Focus Sessions and Activity Tracking:** Daily and weekly streak metrics tracking platform engagement.
* **Upcoming Engagements:** Calendar alerts for scheduled live classes, assignment deadlines, and institutional events.

#### 1.2 Interactive Course Player
* **Structured Curriculum Navigation:** Dynamic sidebar indexing sections, video lectures, document readings, interactive quizzes, and downloadable resources.
* **Lesson Progress Tracking:** Automated lesson completion triggers, progress bars, and sequential lesson unlocking.
* **Multi-Format Content Delivery:** High-definition video player, embedded PDF reader for regulatory documents, rich-text lecture notes, and downloadable supplementary resources.
* **Integrated Course Discussions:** Lesson-level threaded discussions allowing students to pose questions directly to course instructors and peer cohorts.
* **Course Reviews and Ratings:** Post-completion rating system with written feedback and star ratings.

#### 1.3 Assessment and Examination Engine
* **Interactive Quizzes:** Timed and untimed multiple-choice assessments with immediate grading, randomized question banks, and pass/fail thresholds.
* **Detailed Quiz Results:** Question-by-question review highlighting correct answers, student choices, and instructor explanations.
* **Assignment Submission System:** File upload support for coursework, financial case studies, and compliance audits with submission status tracking and revision history.
* **Instructor Feedback and Scoring:** Direct access to instructor grades, rubric scores, and qualitative assessment commentary.

#### 1.4 Professional Certification
* **Automated Issuance:** Triggered automatically upon reaching 100% course completion and meeting all assessment passing criteria.
* **High-Resolution Vector PDF Download:** Print-ready A4 landscape certificates branded with official PBZ seals, signature assets, and cryptographic verification IDs.
* **Public QR Code Verification:** Instant verification link and scannable QR code embedded directly on each certificate for regulatory and third-party audit validation.

#### 1.5 Live Banking Masterclasses
* **Live Session Participation:** Integration with live streaming platforms (Zoom, embedded video conferences) for real-time compliance briefings and executive lectures.
* **Session Schedules and Countdowns:** Automated notifications, join links, and calendar integration for upcoming live classes.

#### 1.6 Student Communication and Collaboration
* **Direct Messaging:** Private, real-time messaging between students and course instructors.
* **Community Q&A Forum:** Public peer-to-peer inquiry portal allowing learners to ask domain-specific questions, upvote useful responses, and mark resolved answers.
* **PBZ AI Banking Assistant:** In-app artificial intelligence assistant providing instantaneous guidance on banking concepts, course topics, and regulatory terms.
* **Notification Center:** Real-time system notifications covering enrollment approvals, assignment grading, certificate issuance, and platform announcements.

#### 1.7 Event Bookings and Attendance
* **Academy Events Directory:** Browse scheduled physical and virtual seminars, workshops, and compliance summits.
* **Self-Service Ticket Booking:** Multi-tier seat reservation with automated e-ticket issuance and PDF download featuring unique verification references.

#### 1.8 Profile and Security Management
* **Profile Customization:** Personal information, professional biography, job title, employee ID, and avatar management.
* **Account Security:** Self-service password changes, email address verification, and session management.

#### 1.9 Regulatory Compliance & Branch Oversight (`/compliance`)
* **Learner Compliance Overview:** Direct learner access to Bank of Tanzania (BOT) statutory training requirements, assigned AML/CFT modules, and audit completion status.
* **Branch Matrix Overview:** Institutional dashboard displaying branch-level regulatory standing, inspection schedules, and statutory certification deadlines.

---

### 2. Instructor Portal and Academic Authoring

The Instructor Portal empowers internal subject-matter experts, senior banking officers, and external instructors to create, deliver, and manage educational curricula.

#### 2.1 Instructor Dashboard and Analytics
* **Executive Metrics:** Aggregate student enrollments, course engagement, active courses, and average student satisfaction ratings.
* **Enrollment Trajectory:** Graphical visualizations illustrating month-over-month enrollment and student completion trends.
* **Recent Activity Feed:** Real-time log of recent student enrollments, assignment submissions, and newly posted course reviews.

#### 2.2 Course Creation and Curriculum Management
* **Multi-Step Course Builder:** Intuitive authoring workflow covering basic course information, media uploads, curriculum architecture, and SEO metadata.
* **AI-Assisted Course Generation:** Integrated generative AI tools to draft comprehensive course titles, outlines, learning objectives, and descriptive promotional copy.
* **Curriculum Hierarchy:** Hierarchical organization with unlimited sections, sequential lessons, downloadable attachments, and media assignments.
* **Multi-Format Lesson Types:** Support for native video uploads, external video links (YouTube, Vimeo), document reading lessons, downloadable templates, quizzes, and assignments.

#### 2.3 Modern Pedagogical & Learning Tools (Moodle-Grade Capabilities)
* **Embedded Interactive Components:** Authoring interface enabling instructors to embed rich interactive elements directly into lecture content:
  - **Dynamic Charting:** Interactive visual charts (bar, line, pie, financial trend charts) embedded inline for banking risk analysis and financial statement breakdown.
  - **Formula & Equation Rendering:** Mathematical and financial formula formatting for banking calculation examples (e.g., loan amortization, capital adequacy ratios, interest rate swaps).
  - **Code & Syntax Highlighting:** Enriched code blocks for fintech, database, and quantitative finance curricula.
  - **Callout & Alert Boxes:** Highlighted regulatory warnings, compliance notices, and key statutory takeaways.
  - **Embedded External Learning Objects:** Embed support for external interactive widgets, compliance simulators, and slide decks.

#### 2.4 Assessment and Examination Administration
* **Quiz Builder:** Creation of comprehensive question pools with customizable passing percentages, time limits, and retake allowances.
* **Assignment Management:** Creation of case study prompts with deadline enforcement and downloadable assignment briefing documents.
* **Grading and Feedback Interface:** Centralized submission queue enabling instructors to inspect submitted student files, assign percentage or numeric scores, and deliver contextual written feedback.
* **Quiz Performance Auditing:** Cohort-wide assessment analytics displaying attempt counts, pass/fail ratios, and question-level difficulty breakdowns.

#### 2.5 Live Session Hosting
* **Live Class Scheduler:** Ability to schedule, configure, and launch live webinars directly linked to specific enrolled course cohorts.
* **Meeting Configuration:** Integration options for external meeting URLs, meeting passwords, agendas, and scheduled start times.

#### 2.6 Course Bundles and Promotional Tools
* **Course Bundling:** Grouping multiple related courses into a single structured curriculum track to drive cross-disciplinary training.
* **Coupon and Discount Engine:** Generation of percentage or fixed-amount promotional codes with custom validity windows and maximum usage thresholds.

#### 2.7 Student Engagement and Inquiries
* **Course Discussion Forums:** Centralized inbox to monitor and answer student questions across all managed courses.
* **Review Moderation and Replies:** Public reply capability to address student ratings and feedback directly.
* **Direct Student Chat:** One-on-one communication interface to mentor individual students and provide direct academic support.

---

### 3. Administrative Portal and Platform Governance

The Administrative Portal equips PBZ LMS administrators with end-to-end command and control over academic operations, regulatory compliance, financial clearance, user lifecycle management, and system infrastructure.

#### 3.1 Executive KPI Dashboard
* **Dynamic Metric Cards:** Live counters for Total Courses, Enrolled Students, Certified Graduates, Active Instructors, Gross Platform Revenue, and Pending Withdrawals.
* **Academic Outcome Metrics:** Real-time status breakdown for Active Courses, Pending Approvals, Draft Courses, Rejected Submissions, Bundles, Total Lessons, and System Quizzes.
* **Revenue and Enrollment Visualizations:** Interactive temporal graphs plotting platform-wide financial intake and user registration velocities.
* **Top Performing Courses:** Ranking table showcasing highest enrolled courses and completion rates across the academy.

#### 3.2 Academic Curriculum and Catalog Control
* **Course Approval Workflow:** Strict editorial review queue enabling administrators to inspect, preview, approve, or reject instructor-submitted courses with required revision notes.
* **Category and Subcategory Taxonomy:** Multi-level categorical structuring to organize banking disciplines (e.g., Islamic Banking, AML/CFT, Credit Risk, Treasury Operations).
* **Language Management:** Multilingual taxonomy configuration supporting English, Swahili, and additional institutional languages.
* **Bundle Administration:** Platform-wide oversight of created course packages and enrollment rules.

#### 3.3 User Directory, Granular RBAC & CUD Lifecycle Governance
* **Bank Staff & Officers Management (`/admin/students`):**
  - **Full CUD Operations:** Create new staff accounts, edit profile details (employee ID, phone, job title), view detailed student transcripts, and safely delete accounts.
  - **Granular Permissions:** Governed by `student:create`, `student:update`, and `student:delete` permissions rather than hardcoded role comparisons.
* **Instructor Directory & Management (`/admin/instructors`):**
  - **Full CUD Operations:** Provision and activate new instructors, edit instructor specializations and bio, view comprehensive teaching stats, and delete accounts.
  - **Application Vetting Queue:** Review pending instructor applications with formal approve and reject workflows.
  - **Course Dependency Safety Check:** Built-in validation prevents the deletion of instructors with active assigned courses, ensuring curriculum integrity.
  - **Granular Permissions:** Governed by `instructor:create`, `instructor:update`, and `instructor:delete` permissions.
* **Defensive Self-Deletion Prevention:**
  - Administrators are explicitly blocked by the Gate interceptor layer from deleting their own active logged-in account, preventing accidental institutional lockouts.
* **Administrative Impersonation:** Secure "Login As" mechanism allowing authorized administrators to troubleshoot user-reported issues directly within the student or instructor view.
* **Manual Enrollment Override:** Capability to manually enroll employees, departments, or individual students into courses or bundles without processing financial transactions.

#### 3.4 Regulatory Compliance & Branch Oversight Matrix (`/admin/compliance`)
* **Bank of Tanzania (BOT) Compliance Engine:**
  - Dedicated audit and tracking console monitoring staff regulatory compliance across core banking regulations (AML/CFT, Cyber Resilience, Consumer Protection, Fraud Prevention).
  - Real-time compliance health scorecards and statutory filing readiness.
* **Branch Oversight Matrix (`/admin/compliance/branch-matrix`):**
  - Matrix indexing all PBZ branches across Unguja, Pemba, and Mainland Tanzania.
  - Branch risk rating classification (Low Risk, Medium Risk, High Risk) based on employee certification completion percentages.
  - Quick-filter capability by risk level, inspection cycle, and regional zone.
  - Direct branch inspection scheduling and compliance alert dispatching.

#### 3.5 Drag-and-Drop Certificate Designer and Template CMS
* **Visual Drag-and-Drop Canvas:** Interactive A4 landscape design workspace operating on exact physical proportions (1123 x 794 pixels) for millimeter-precise PDF printing.
* **Custom Background Uploader:** Ability to upload custom branded high-resolution guilloche certificate backgrounds, border designs, and institutional watermarks.
* **Dynamic Element Positioning:** Drag, drop, align, and position dynamic text blocks, signatures, seals, and QR code blocks with live coordinate calculation.
* **Placeholder Token Engine:** Automated token substitution for `{student_name}`, `{course_title}`, `{instructor_name}`, `{completion_date}`, `{certificate_id}`, and `{platform_name}`.
* **Real-Time Layout Synchronization:** Template layout parameters (x, y coordinates, font size, color, font weight, visibility) persist as structured JSON and automatically propagate across all existing and newly generated certificates.
* **Interactive Live Preview Modal:** In-browser full-fidelity preview demonstrating exact template rendering using mock learner credentials prior to saving changes.
* **Default Template Designations:** Configurable system-wide default templates with automated fallback routing for newly completed courses.

#### 3.6 Financial Clearance and Payment Management
* **Offline Payment Verification Queue:** Administrative verification portal to inspect bank transfer slips, validate reference numbers, and approve or reject pending offline orders with automated enrollment activation.
* **Multi-Gateway Transaction Ledger:** Comprehensive search, filter, and audit trail of all transactions processed via Stripe, PayPal, Paystack, Flutterwave, SSLCommerz, Mollie, bKash, and xPay.
* **Instructor Payout Processing:** Centralized review and approval interface for instructor earnings withdrawals with direct bank transfer reconciliation.
* **Coupon Auditing:** Platform-wide monitoring of promotional coupon usage and discount liability.

#### 3.7 Event Management and Verification
* **Academy Events Builder:** Creation of institutional seminars, training workshops, and public conferences with rich agendas, schedule tracking, speaker profiles, and location data.
* **Seat and Ticket Allocation:** Automated ticketing inventory management with tiered pricing and capacity enforcement.
* **Public Ticket Verification:** Dedicated verification route (`/events/bookings/verify/{reference}`) to validate physical and digital tickets at event entry points.

#### 3.8 Institutional Knowledge and CMS
* **Banking Insights Blog:** Full-featured article publishing system with category tagging, featured images, rich-text editor, and comment moderation.
* **Content and Navigation Menus:** Customizable header and footer navigation menus linked to internal or external institutional resources.
* **Promotional Banners:** Configurable promotional banners to spotlight priority regulatory certifications or executive messages across the homepage.

#### 3.9 System Settings, Integrations, and Maintenance
* **Brand Identity Configuration:** Upload system logos, dark/light variants, favicons, bank copyright notices, and regulatory registration statements.
* **SMTP and Email Notification Settings:** Centralized mail server configuration (host, port, encryption, credentials) with automated test mail delivery.
* **Multi-Gateway API Credentials:** Centralized configuration forms for merchant keys, secrets, webhooks, and sandbox/production environment toggles.
* **Artificial Intelligence Engine Setup:** API key configuration and model selection for generative AI course drafting and the student banking assistant.
* **System Maintenance and Cache Utility:** Single-click administrative clearing of application caches, route caches, compiled views, and configuration caches.
* **Automated Cron and Scheduled Tasks:** Background worker management handling enrollment expiration, reminder emails, and analytics rollups.

---

### 4. Public Academy Portal and Guest Experience

The public-facing portal serves as the primary storefront and knowledge hub for PBZ, catering to retail banking customers, corporate partners, and external financial practitioners.

#### 4.1 Digital Front Door and Course Discovery
* **Responsive Landing Page:** High-impact institutional hero section, value propositions, key statistics, featured courses, and student testimonials.
* **Faceted Course Catalog:** Multi-dimensional filtering by category, difficulty level (Beginner, Intermediate, Advanced), price (Free, Paid), rating, and language.
* **In-Depth Course Detail Pages:** Comprehensive curriculum previews, instructor credentials, learning outcomes, prerequisite declarations, review breakdowns, and enrollment call-to-actions.
* **Course Bundles Directory:** Showcase of multi-course packages offering bundled pricing discounts for comprehensive banking tracks.

#### 4.2 Public Credential Verification Portal
* **Independent Certificate Verification:** Dedicated public lookup tool (`/verify-certificate`) enabling employers, regulatory bodies, and academic institutions to verify the legitimacy of issued certificates by entering the unique Certificate ID.
* **Live Credential Display:** Displays certified student name, course title, completion date, issuing instructor, and verification status with an official PBZ seal of authenticity.

#### 4.3 Corporate Information and Knowledge Sharing
* **Institutional Blog and Research:** Publication of banking research, regulatory updates (e.g., Bank of Tanzania directives), and executive insights.
* **About PBZ Academy:** Institutional history, mission, accreditation details, and leadership profiles.
* **Interactive Contact Portal:** Direct inquiry forms routing messages directly to academy support teams.

#### 4.4 Checkout and Enrollment Pipeline
* **Unified Shopping Cart and Direct Checkout:** Frictionless purchase flow supporting single course acquisitions or course bundles.
* **Coupon Application Engine:** Real-time coupon code validation and instant total deduction.
* **Secure Payment Processing:** Secure redirect and webhook-driven callback verification ensuring automated course access immediately upon payment confirmation.

---

### 5. Security, Regulatory Compliance, and Governance

The PBZ LMS is engineered to comply with strict banking industry standards and regulatory frameworks, including Bank of Tanzania (BOT) IT governance principles.

* **Capability-Based Granular RBAC:** Permissions are decoupled from raw role strings and enforced via Spatie permissions and Laravel Gates (`instructor:create`, `instructor:update`, `instructor:delete`, `student:create`, `student:update`, `student:delete`).
* **Self-Deletion Attack Mitigation:** Gate-level and controller-level veto checks prevent administrators from deleting their own active profile, ensuring business continuity.
* **Integrity Constraints on User Deletion:** Deletion of instructors with active courses is blocked to preserve course curriculum and student enrollment history.
* **Audit Logging:** Exhaustive logging of administrative actions, user logins, course modifications, and financial status changes.
* **Data Privacy and Protection:** Encryption of sensitive user data at rest and in transit (HTTPS/TLS enforcement).
* **Role Separation:** Strict compartmentalization preventing cross-role privilege escalation between students, instructors, and administrators.
* **Tamper-Resistant Certification:** Unique cryptographically formatted certificate IDs linked to immutable database completion records.
* **Regulatory Compliance Training Tracking:** Detailed reporting capabilities enabling compliance officers to verify 100% staff completion of mandatory AML/CFT and financial crime modules.

---

### 6. Strategic Business and Organizational Benefits

Deploying the PBZ Learning Management System delivers measurable operational, strategic, and financial advantages to the institution, its workforce, and external stakeholders.

#### 6.1 Regulatory Compliance and Risk Mitigation
* **Mandatory Compliance Enforcement:** Guarantees centralized, verifiable distribution of mandatory banking training programs, including Anti-Money Laundering (AML), Combating the Financing of Terrorism (CFT), Know Your Customer (KYC), and Bank of Tanzania (BOT) statutory guidelines.
* **Audit-Ready Compliance Records:** Provides automated logging of module completions, assessment attempts, and passing scores, allowing internal compliance teams and central bank inspectors to audit employee regulatory certifications on demand.
* **Reduced Legal and Operational Exposure:** Eliminates compliance gaps and regulatory fines caused by delayed or inconsistent employee training across regional branches.

#### 6.2 Operational Cost Reduction and Capital Efficiency
* **Elimination of Recurring Training Overhead:** Replaces costly in-person seminar logistics, travel expenses, venue hires, catering, and printed materials with reusable, cloud-hosted digital curricula.
* **Rapid, Zero-Marginal-Cost Scaling:** Enables instantaneous onboarding and skills refreshers for hundreds of new hires and branch personnel across Zanzibar, Pemba, and mainland Tanzania without increasing per-trainee delivery costs.
* **Automated Administrative Workflows:** Eliminates manual administrative burden through automated certificate generation, self-service enrollment, auto-graded assessments, and self-clearing digital payments.

#### 6.3 Standardized Service Delivery and Knowledge Preservation
* **Consistent Operating Procedures:** Establishes a single source of truth for standard operating procedures (SOPs), credit risk appraisal frameworks, customer service protocols, and Islamic banking principles (Amana).
* **Institutional Knowledge Retention:** Preserves critical expertise, domain insights, and regulatory lessons from senior executives and veteran bankers in structured digital courses, preventing intellectual capital loss due to staff turnover or retirement.
* **Unified Branch Quality:** Ensures branch officers across all geographical locations receive identical high-standard guidance, delivering consistent banking service quality to customers.

#### 6.4 Workforce Upskilling and Employee Engagement
* **24/7 Flexible Professional Development:** Enables employees to balance demanding branch operational hours with self-paced learning accessible anytime from desktop or mobile devices.
* **Measurable Career Progression:** Clear certification tracks motivate staff, support internal promotion vetting, and foster employee retention by investing directly in personal career growth.
* **Interactive Cohort Learning:** Encourages horizontal collaboration through course discussions, community forums, and direct mentorship from internal subject-matter experts.

#### 6.5 New Revenue Streams and Commercial Academy Potential
* **External Monetization of Banking Courses:** Positions the PBZ Academy as a commercial education provider, offering paid professional certifications in Islamic finance, corporate governance, and risk management to external financial practitioners and university graduates.
* **Multi-Channel Revenue Intake:** Captures enrollment revenue seamlessly through integrated international credit cards, regional mobile money services, and direct PBZ offline account deposits.
* **Executive Event Ticketing:** Facilitates paid physical and virtual symposiums, banking conferences, and executive masterclasses through the integrated event booking engine.

#### 6.6 Brand Equity and Regional Thought Leadership
* **Institutional Prestige:** Solidifies the People's Bank of Zanzibar's reputation as "The Bank That Listens" and an innovative pioneer in East African financial technology and education.
* **Public Credential Trust:** Tamper-resistant, QR-code-verified digital certificates enhance credential legitimacy among employers, academic partners, and international certification bodies.

#### 6.7 Data-Driven Talent Analytics
* **Executive Competency Visibility:** Real-time dashboards provide HR leadership and branch managers with actionable data on staff competency levels, assessment pass rates, and knowledge gaps.
* **Targeted Intervention:** Pinpoints challenging compliance topics or technical modules where staff struggle, enabling rapid curriculum refinements and targeted coaching.

---

### 7. Implementation Status and Strategic Roadmap

The platform balances high-velocity production capabilities with a future-proof roadmap tailored for ongoing banking expansion.

#### 7.1 Production Active Capabilities [LIVE]
* **Granular Role-Based Access Control (RBAC):** Indirection layer mapping granular permissions (`instructor:create`, `instructor:update`, `instructor:delete`, `student:create`, `student:update`, `student:delete`) across full admin CUD workflows with self-deletion protection.
* **Bank of Tanzania (BOT) Compliance Engine:** Specialized compliance center monitoring branch inspection cycles, statutory training completion rates, and regulatory health scorecards.
* **Branch Oversight Matrix:** Zone-by-zone (Unguja, Pemba, Mainland Tanzania) oversight of branch compliance performance, risk banding, and audit preparedness.
* **Moodle-Grade Learning Tools:** Integrated interactive components, embedded financial charts, formula formatters, and rich callouts for course authoring.
* **Drag-and-Drop Certificate Studio:** Millimeter-accurate visual canvas generator with dynamic tokens, custom guilloche background uploader, and instant vector PDF rendering.
* **Multi-Gateway Financial Processing:** Multi-channel payment pipeline with manual bank transfer receipt review and automated clearance triggers.

#### 7.2 Upcoming Implementations and Enterprise Roadmap
* **Regulatory Re-Certification and Lifecycle Automation:** Configurable 365-day certification validity with automated re-enrollment and non-compliance escalation alerts.
* **Multi-Branch & Departmental Organizational Units:** Deep organizational hierarchy mapping (Directorate -> Department -> Zone -> Branch) with targeted departmental auto-enrollment rules.
* **Line Manager and Supervisor Portal ("Manager-in-the-Loop"):** Subordinate compliance dashboards, OJT practical competency checklists, and course request sign-offs.
* **Continuing Professional Development (CPD) & Credit Hours:** Verified credit hours engine with official annual transcript generation for regulatory bodies (TIOB, NBAA, ACAMS).
* **Enterprise Single Sign-On (SSO) & Core HRMS Integration:** Microsoft Entra ID (Azure AD) / SAML 2.0 federation with automated nightly employee roster synchronization.
* **Automated Regulatory Audit Packs:** Single-click generation of Bank of Tanzania compliance inspection bundles with timestamped attempt logs.
* **SCORM / xAPI Package Player:** Support for uploading external vendor banking packages (Moody's, Euromoney) with automatic progress syncing.
* **Progressive Web App (PWA) & Offline Player:** Local caching of lecture notes and policy documents for low-bandwidth branch environments.

---

### Summary of Platform Roles and Capabilities

| Capability Domain | Student / Staff | Instructor | Administrator |
| :--- | :---: | :---: | :---: |
| Self-Paced Course Learning | Yes | Preview Only | Full Access |
| Interactive Quizzes and Assignments | Submits | Grades and Creates | Full Audit |
| Automated Certificate Issuance | Receives | Supervises | Designs and Configures |
| Course and Curriculum Creation | No | Full Authoring | Full Review and Approval |
| Moodle-Grade Embedded Learning Tools | Uses in Player | Creates and Embeds | Full Oversight |
| Drag-and-Drop Certificate Designer | No | No | Full Access |
| BOT Compliance & Branch Oversight Matrix | Learner View | Learner View | Full Management & CUD |
| Bank Staff & Trainees Management | No | No | Full CUD (`student:*`) |
| Instructors Management | No | No | Full CUD (`instructor:*`) |
| User and Role Impersonation | No | No | Full Control |
| Public Certificate Verification | Verification Access | Verification Access | Full Control |
| Event Ticket Booking and Validation | Books Tickets | Hosts Events | Author and Verify |
| Direct Messaging and Chat | Direct to Instructor | Direct to Student | Full Oversight |
| System Configuration and Gateways | No | No | Full Control |

---

### 8. Institutional Demo Access & Persona Fast-Sign-In

The authentication portal (`/login`) includes 1-click **Institutional Demo Access** with instant automated sign-in:

* **Universal Demo Password:** `password123`
* **Branch Manager:**
  - **Account:** `manager.forodhani@pbzbank.co.tz`
  - **Role & Scope:** Branch Operations Manager · Forodhani Main Branch · Oversight Matrix & Staff Countdown Supervision
* **Senior Teller:**
  - **Account:** `renatus.bernardo@pbzbank.co.tz`
  - **Role & Scope:** Senior Teller & Frontline KYC Officer · Forodhani Branch · Active Countdowns & Mandatory AML Modules
* **Compliance Faculty:**
  - **Account:** `compliance@pbzbank.co.tz`
  - **Role & Scope:** Head of AML & Regulatory Compliance (Instructor) · BOT Mandates & Trainee Audit
* **Executive Admin:**
  - **Account:** `admin@pbzbank.co.tz`
  - **Role & Scope:** PBZ Executive Administrator · Sovereign Bank Governance & Full Portal Oversight

---
*Document Version: 2.0.0*  
*Classification: Internal and Partner Technical Specification*  
*People's Bank of Zanzibar (PBZ) Learning Management System*

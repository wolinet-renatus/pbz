<?php

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Bundle;
use App\Models\Course;
use App\Models\CourseTopic;
use App\Models\Enrollment;
use App\Models\Event;
use App\Models\EventHighlight;
use App\Models\EventSpeaker;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use App\Models\QuizQuestion;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting PBZ Demo Data Enhancement...\n";

DB::beginTransaction();

try {
    // 1. Update Instructor Profile
    $instructor = User::find(2);
    if ($instructor) {
        $instructor->name = 'Dr. Amina Khamis Salim';
        $instructor->specialization = 'Regulatory Compliance, AML/CFT & Shariah Banking';
        $instructor->years_experience = 18;
        $instructor->highest_degree = 'Ph.D. in Financial Law & Banking Regulation';
        $instructor->field_of_study = 'Commercial Banking & Islamic Finance';
        $instructor->certifications = 'TIOB Certified Banking Practitioner, CAMS, AAOIFI Shariah Auditor';
        $instructor->bio = 'Over 18 years of executive commercial banking experience across East Africa. Former Senior Bank of Tanzania (BOT) Bank Examiner, Fellow of the Tanzania Institute of Bankers (TIOB), and Chief Compliance Advisor for People\'s Bank of Zanzibar.';
        $instructor->save();
        echo "✓ Instructor profile updated: Dr. Amina Khamis Salim\n";
    }

    // 2. Fetch Courses
    $course1 = Course::find(1); // AML / CFT
    $course2 = Course::find(2); // Amana Islamic
    $course3 = Course::find(3); // Cyber Hygiene

    // Ensure thumbnails
    if ($course1) {
        $course1->featured_image = 'courses/aml-cft.svg';
        $course1->save();
    }
    if ($course2) {
        $course2->featured_image = 'courses/amana-islamic.svg';
        $course2->save();
    }
    if ($course3) {
        $course3->featured_image = 'courses/cyber-hygiene.svg';
        $course3->save();
    }

    // --- ENHANCE COURSE 1 (AML/CFT) ---
    if ($course1) {
        // Topic 1 Lessons
        $topic1 = CourseTopic::firstOrCreate(
            ['course_id' => $course1->id, 'title' => 'Topic 1: AML / CFT Regulatory Foundations & BOT Directives'],
            ['order' => 1]
        );

        $l1 = Lesson::updateOrCreate(
            ['course_topic_id' => $topic1->id, 'title' => 'Lesson 1.1: The Three Stages of Money Laundering (Placement, Layering, Integration)'],
            [
                'order' => 1,
                'content' => '<h3>Understanding the Money Laundering Life Cycle in Commercial Banking</h3>
<p>Anti-Money Laundering (AML) controls within <strong>People\'s Bank of Zanzibar (PBZ)</strong> are designed to detect illicit capital across all three critical operational phases:</p>
<div class="alert alert-info">
  <h5>1. Placement Phase</h5>
  <p>The introduction of illegal proceeds into the financial system. Common techniques at branch counters include <em>smurfing</em> (splitting large deposits below reporting thresholds), multi-currency conversions, and commingled cash-intensive business receipts.</p>
</div>
<div class="alert alert-warning">
  <h5>2. Layering Phase</h5>
  <p>Distance created between the source of illicit funds and their current location through intricate transaction webs. At PBZ, this includes wire transfers to offshore correspondent banks, rapid shell company transactions, and fake commercial invoices.</p>
</div>
<div class="alert alert-success">
  <h5>3. Integration Phase</h5>
  <p>Re-entry of laundered capital into the legitimate economy, appearing as bona fide wealth. Examples include luxury real estate acquisitions in Stone Town, vessel purchases for blue economy operations, or commercial loans collateralized by offshore deposits.</p>
</div>
<p><strong>Mandatory PBZ Directive:</strong> Branch tellers and relationship managers must immediately document and report unusual velocity or structured cash transactions using the PBZ Core Compliance Portal.</p>'
            ]
        );

        $l2 = Lesson::updateOrCreate(
            ['course_topic_id' => $topic1->id, 'title' => 'Lesson 1.2: Bank of Tanzania (BOT) Guidelines on Sanctions & Politically Exposed Persons (PEPs)'],
            [
                'order' => 2,
                'content' => '<h3>Enhanced Due Diligence (EDD) for Politically Exposed Persons</h3>
<p>In accordance with the <strong>Anti-Money Laundering Act, Cap 423</strong> and Bank of Tanzania (BOT) Directives:</p>
<ul>
  <li><strong>Definition of PEP:</strong> Individuals entrusted with prominent public functions in Tanzania, Zanzibar Revolutionary Government, or foreign jurisdictions, including their immediate family members and close associates.</li>
  <li><strong>Senior Management Approval:</strong> No PBZ branch or business unit may open an account or establish a business relationship with a PEP without written approval from the Head of Risk & Compliance and the Managing Director.</li>
  <li><strong>Source of Wealth & Funds:</strong> Concrete documentary proof must be obtained verifying the origin of both net worth and specific transactional funds.</li>
  <li><strong>Continuous Monitoring:</strong> All accounts associated with PEPs are subject to daily automated transaction screening against UN, OFAC, and EAC sanctions lists.</li>
</ul>'
            ]
        );

        // Topic 2
        $topic2 = CourseTopic::firstOrCreate(
            ['course_id' => $course1->id, 'title' => 'Topic 2: Cash Structuring Detection & Compliance Assessment'],
            ['order' => 2]
        );

        $l3 = Lesson::updateOrCreate(
            ['course_topic_id' => $topic2->id, 'title' => 'Lesson 2.1: Smurfing & Cash Structuring Detection at Branch Tellers'],
            [
                'order' => 1,
                'content' => '<h3>Front-Line Detection: Countering Smurfing and Structuring</h3>
<p>Cash structuring occurs when an individual deliberately splits deposits or withdrawals into smaller amounts to remain beneath mandatory regulatory thresholds (e.g., USD 10,000 or TZS equivalent):</p>
<h4>Red Flag Indicators for PBZ Tellers:</h4>
<ol>
  <li>A customer conducting multiple cash deposits of TZS 9,500,000 across multiple PBZ branches (e.g., Malindi, Forodhani, and Mpirani) within 48 hours.</li>
  <li>Third-party agents or unverified couriers presenting deposits into third-party business accounts without clear commercial nexus.</li>
  <li>Customer altering or cancelling a proposed cash transaction immediately upon being informed of Currency Transaction Report (CTR) identification requirements.</li>
</ol>
<p><strong>Crucial Rule (Anti-Tipping Off):</strong> Bank personnel are strictly prohibited by law from disclosing to the customer that an inquiry or Suspicious Transaction Report (STR) has been initiated. Violations incur severe criminal and regulatory penalties.</p>'
            ]
        );

        // Quiz 2
        $quiz1 = Quiz::updateOrCreate(
            ['course_topic_id' => $topic2->id],
            [
                'title' => 'BOT AML/CFT Mandatory Knowledge Assessment (Pass Mark: 80%)',
                'description' => 'Comprehensive Bank of Tanzania regulatory compliance assessment covering Money Laundering lifecycle, PEP screening, CTR/STR filing, and anti-tipping off rules.',
                'passing_score' => 80,
                'time_limit' => 25,
            ]
        );

        // Populate Quiz Questions
        QuizQuestion::where('quiz_id', $quiz1->id)->delete();
        $questionsData1 = [
            [
                'question' => 'What is the primary objective of "Structuring" (Smurfing) in commercial banking transactions?',
                'options' => [
                    'To maximize interest yields on short-term treasury bills',
                    'To deliberately evade mandatory statutory Currency Transaction Reporting (CTR) thresholds',
                    'To shorten branch counter queuing times during peak hours',
                    'To hedge foreign exchange exposure between TZS and USD'
                ],
                'correct_answer' => 1,
                'order' => 1,
            ],
            [
                'question' => 'Under Bank of Tanzania (BOT) regulations, what is the mandatory protocol when a customer exhibits suspicious transaction behavior at a PBZ counter?',
                'options' => [
                    'Confront the customer directly and request a notarized confession statement',
                    'Discard the transaction records if the account holder is personally known to branch staff',
                    'Execute the transaction without tipping off the client, and immediately file an internal Suspicious Transaction Report (STR)',
                    'Lock branch exit gates and summon local security guards'
                ],
                'correct_answer' => 2,
                'order' => 2,
            ],
            [
                'question' => 'Under Tanzanian AML legislation, what constitutes "Tipping Off"?',
                'options' => [
                    'Disclosing to an unauthorized party or the customer that a suspicious transaction report or AML investigation is underway',
                    'Advising a business customer on BOT interest rate caps',
                    'Offering banking tips to corporate clients on export finance facilities',
                    'Recommending PBZ Amana Islamic banking alternatives'
                ],
                'correct_answer' => 0,
                'order' => 3,
            ],
            [
                'question' => 'Who must approve the onboarding of a Politically Exposed Person (PEP) at People\'s Bank of Zanzibar?',
                'options' => [
                    'Any junior bank teller handling customer service',
                    'Senior Bank Management / Chief Risk & Compliance Officer and Managing Director',
                    'The local branch security supervisor',
                    'The customer\'s external legal counsel'
                ],
                'correct_answer' => 1,
                'order' => 4,
            ],
            [
                'question' => 'At which stage of money laundering are illicit funds converted into legitimate luxury assets or registered commercial equity?',
                'options' => [
                    'Placement phase',
                    'Layering phase',
                    'Integration phase',
                    'Extraction phase'
                ],
                'correct_answer' => 2,
                'order' => 5,
            ],
        ];

        foreach ($questionsData1 as $q) {
            QuizQuestion::create([
                'quiz_id' => $quiz1->id,
                'question' => $q['question'],
                'type' => 'multiple-choice',
                'options' => $q['options'],
                'correct_answer' => $q['correct_answer'],
                'order' => $q['order'],
            ]);
        }

        // Topic 3: Assignment
        $topic3 = CourseTopic::firstOrCreate(
            ['course_id' => $course1->id, 'title' => 'Topic 3: Incident Escalation & Practical Case Study'],
            ['order' => 3]
        );

        $assignment1 = Assignment::updateOrCreate(
            ['course_topic_id' => $topic3->id],
            [
                'title' => 'Branch Scenario Case Study: Suspicious Cash Deposit at Forodhani Branch',
                'description' => 'A practical real-world scenario evaluating an unusual deposit of TZS 95,000,000 cash brought in duffel bags to the PBZ Forodhani Branch without documented commercial rationale.',
                'instructions' => '<p>Review the provided scenario details and draft a formal internal <strong>Suspicious Transaction Report (STR)</strong> memo addressed to the PBZ Chief Compliance Officer. Your memo must detail:</p>
<ol>
  <li>Specific AML Red Flag indicators observed under BOT regulations.</li>
  <li>Immediate actions taken by the Branch Operations Manager and Head Cashier.</li>
  <li>Verification measures conducted (PEP screening, company registry search, source of wealth audit).</li>
  <li>Recommended statutory escalation to the Financial Intelligence Unit (FIU) Tanzania.</li>
</ol>',
                'order' => 1,
            ]
        );
    }

    // --- ENHANCE COURSE 2 (PBZ AMANA ISLAMIC BANKING) ---
    if ($course2) {
        $c2t1 = CourseTopic::firstOrCreate(
            ['course_id' => $course2->id, 'title' => 'Topic 1: Foundations of Islamic Banking & Shariah Governance'],
            ['order' => 1]
        );

        Lesson::updateOrCreate(
            ['course_topic_id' => $c2t1->id, 'title' => 'Lesson 1.1: Core Prohibitions: Riba (Interest), Gharar (Uncertainty) & Maysir (Gambling)'],
            [
                'order' => 1,
                'content' => '<h3>The Ethical Bedrock of PBZ Amana Islamic Banking</h3>
<p>PBZ Amana operates under strict Shariah compliance principles rooted in equity, social justice, and asset-backed real economic participation.</p>
<h4>1. Prohibition of Riba (Usury / Interest)</h4>
<p>Money in Islamic finance is a medium of exchange, not an asset that generates guaranteed returns merely through elapsed time. PBZ Amana replaces interest with asset-backed profit margins and risk-sharing equity.</p>
<h4>2. Elimination of Gharar (Excessive Ambiguity)</h4>
<p>All contract terms, asset specifications, delivery timelines, and price structures must be transparently defined at contract inception. Deceptive ambiguity is strictly forbidden.</p>
<h4>3. Elimination of Maysir & Qimar (Speculation & Gambling)</h4>
<p>Transactions based on pure chance, unhedged financial speculation, or non-productive games of hazard cannot be funded by PBZ Amana.</p>'
            ]
        );

        Lesson::updateOrCreate(
            ['course_topic_id' => $c2t1->id, 'title' => 'Lesson 1.2: The Role of the PBZ Shariah Advisory Board'],
            [
                'order' => 2,
                'content' => '<h3>Independent Shariah Oversight at People\'s Bank of Zanzibar</h3>
<p>The PBZ Shariah Advisory Board comprises distinguished Islamic jurisprudence scholars and banking economists who:</p>
<ul>
  <li>Review and certify every Amana retail and commercial financing product before launch.</li>
  <li>Conduct annual Shariah audits across all PBZ branches offering Islamic windows.</li>
  <li>Ensure strict segregation of Islamic deposits from conventional PBZ treasury funds.</li>
  <li>Direct any non-compliant earnings into the PBZ Islamic Charitable & Community Fund.</li>
</ul>'
            ]
        );

        $c2t2 = CourseTopic::firstOrCreate(
            ['course_id' => $course2->id, 'title' => 'Topic 2: Murabaha & Ijara Financing Contracts'],
            ['order' => 2]
        );

        Lesson::updateOrCreate(
            ['course_topic_id' => $c2t2->id, 'title' => 'Lesson 2.1: Murabaha Asset Acquisition & Title Transfer'],
            [
                'order' => 1,
                'content' => '<h3>Mechanics of Murabaha (Cost-Plus Sale)</h3>
<p>Murabaha is an asset-acquisition contract where PBZ purchases an asset requested by a customer and subsequently sells it to the customer at cost plus an explicitly disclosed, agreed-upon profit margin.</p>
<p><strong>Crucial Shariah Condition:</strong> PBZ must take constructive legal ownership and assume inventory risk of the asset before selling and transferring ownership to the client. Pre-selling goods before bank acquisition renders the contract void under Shariah law.</p>'
            ]
        );

        Lesson::updateOrCreate(
            ['course_topic_id' => $c2t2->id, 'title' => 'Lesson 2.2: Ijara Muntahia Bittamleek (Lease Ending in Ownership)'],
            [
                'order' => 2,
                'content' => '<h3>Asset Leasing in PBZ Corporate & SME Finance</h3>
<p>Under <strong>Ijara Muntahia Bittamleek</strong>, PBZ purchases high-value capital equipment (such as maritime fishing vessels, clove processing machinery, or commercial fleets) and leases the asset to the client for an agreed rental stream.</p>
<p>At the conclusion of the lease term, ownership of the asset is transferred to the customer via gift (Hiba) or nominal token sale, fulfilling both regulatory standards and Islamic jurisprudential guidelines.</p>'
            ]
        );

        $quiz2 = Quiz::updateOrCreate(
            ['course_topic_id' => $c2t2->id],
            [
                'title' => 'PBZ Amana Shariah Compliance Quiz (Pass Mark: 80%)',
                'description' => 'Test your knowledge on Shariah contracts, profit-loss sharing, Murabaha title transfer, and the governance mandate of the PBZ Shariah Board.',
                'passing_score' => 80,
                'time_limit' => 20,
            ]
        );

        QuizQuestion::where('quiz_id', $quiz2->id)->delete();
        $questionsData2 = [
            [
                'question' => 'In a Murabaha contract, what must the bank transparently disclose to the customer prior to contract signing?',
                'options' => [
                    'Only the final monthly installment figure',
                    'Both the original purchase cost and the explicit agreed profit margin',
                    'The bank\'s internal staff salary scale',
                    'Conventional commercial interbank lending rates'
                ],
                'correct_answer' => 1,
                'order' => 1,
            ],
            [
                'question' => 'What happens to any non-compliant earnings identified during an internal PBZ Shariah audit?',
                'options' => [
                    'They are distributed to executive shareholders as bonuses',
                    'They are credited to conventional branch reserve funds',
                    'They are completely purged from bank revenue and redirected to the PBZ Islamic Charitable & Community Fund',
                    'They are returned to the commercial insurance pool'
                ],
                'correct_answer' => 2,
                'order' => 2,
            ],
            [
                'question' => 'Under Islamic jurisprudential principles, why is Riba (Interest) forbidden in commercial banking?',
                'options' => [
                    'Because money must not generate risk-free guaranteed growth disconnected from tangible asset creation or real economic risk',
                    'Because international exchange rates are too volatile',
                    'Because central banks prohibit foreign currency holdings',
                    'Because commercial banks are not allowed to operate outside Zanzibar'
                ],
                'correct_answer' => 0,
                'order' => 3,
            ],
            [
                'question' => 'In a Mudaraba partnership contract, who provides the financial capital?',
                'options' => [
                    'The managing entrepreneur (Mudarib)',
                    'The capital provider / Bank (Rab al-Mal)',
                    'The regional municipal government',
                    'The external independent auditor'
                ],
                'correct_answer' => 1,
                'order' => 4,
            ],
            [
                'question' => 'What distinguishes an Ijara contract from a conventional financial lease?',
                'options' => [
                    'In Ijara, major maintenance and underlying asset risk remain with the lessor (the bank) throughout the lease period',
                    'Ijara does not require any signed paperwork',
                    'Ijara contracts can only last for 30 calendar days',
                    'Ijara cannot be used for commercial equipment'
                ],
                'correct_answer' => 0,
                'order' => 5,
            ],
        ];

        foreach ($questionsData2 as $q) {
            QuizQuestion::create([
                'quiz_id' => $quiz2->id,
                'question' => $q['question'],
                'type' => 'multiple-choice',
                'options' => $q['options'],
                'correct_answer' => $q['correct_answer'],
                'order' => $q['order'],
            ]);
        }
    }

    // --- ENHANCE COURSE 3 (CYBERSECURITY & THREAT DEFENSE) ---
    if ($course3) {
        $c3t1 = CourseTopic::firstOrCreate(
            ['course_id' => $course3->id, 'title' => 'Topic 1: Banking Threat Defense & Social Engineering'],
            ['order' => 1]
        );

        Lesson::updateOrCreate(
            ['course_topic_id' => $c3t1->id, 'title' => 'Lesson 1.1: Spotting Spear-Phishing & Business Email Compromise (BEC)'],
            [
                'order' => 1,
                'content' => '<h3>Cyber Attack Vectors in Modern Banking</h3>
<p>Over 88% of unauthorized intrusions into banking systems begin with social engineering targeting bank personnel.</p>
<h4>Hallmarks of Phishing Emails Targetting PBZ Staff:</h4>
<ul>
  <li><strong>Spoofed Executive Senders:</strong> Messages purporting to come from the PBZ Managing Director or Head of IT urging urgent wire releases.</li>
  <li><strong>Look-alike Domains:</strong> URLs mimicking <code>pbzbank.co.tz</code> (such as <code>pbz-verify.com</code> or <code>pbzbank-portal.net</code>).</li>
  <li><strong>Malicious Attachments:</strong> Invoices with embedded macros or links disguised as "SWIFT Payment Confirmation.pdf.exe".</li>
</ul>
<p><strong>Immediate Action:</strong> Never enter PBZ Active Directory credentials on external sites. Forward suspicious emails to <code>cyber-incident@pbzbank.co.tz</code>.</p>'
            ]
        );

        Lesson::updateOrCreate(
            ['course_topic_id' => $c3t1->id, 'title' => 'Lesson 1.2: Clean Desk, Clean Screen & Physical Branch Security'],
            [
                'order' => 2,
                'content' => '<h3>Physical Security Protocols at PBZ Branches</h3>
<p>Data protection is as much physical as it is digital:</p>
<ol>
  <li><strong>Clean Screen Policy:</strong> Always lock your workstation (<code>Windows Key + L</code>) whenever leaving your counter or desk, even for 30 seconds.</li>
  <li><strong>Clean Desk Policy:</strong> Sensitive banking documents, customer account opening forms, and transaction vouchers must be locked in fireproof cabinets at the close of every business day.</li>
  <li><strong>Unauthorized USBs:</strong> Plugging unapproved thumb drives or mobile phones into PBZ core banking terminals is strictly prohibited by central IT security policies.</li>
</ol>'
            ]
        );

        $c3t2 = CourseTopic::firstOrCreate(
            ['course_id' => $course3->id, 'title' => 'Topic 2: Core Banking Incident Escalation & SWIFT Defense'],
            ['order' => 2]
        );

        Lesson::updateOrCreate(
            ['course_topic_id' => $c3t2->id, 'title' => 'Lesson 2.1: Multi-Factor Authentication & SWIFT CSP Protocols'],
            [
                'order' => 1,
                'content' => '<h3>Securing Interbank Clearing & SWIFT Infrastructure</h3>
<p>The SWIFT Customer Security Programme (CSP) establishes mandatory security baselines for all interconnected financial institutions:</p>
<ul>
  <li>Restricting physical and logical access to the SWIFT terminal environment.</li>
  <li>Mandatory Hardware Security Modules (HSM) and multi-factor biometric tokens for all payment authorizers.</li>
  <li>Immediate isolation protocols upon detection of any anomalous payment traffic.</li>
</ul>'
            ]
        );

        $quiz3 = Quiz::updateOrCreate(
            ['course_topic_id' => $c3t2->id],
            [
                'title' => 'PBZ Banking Cybersecurity & Threat Defense Assessment',
                'description' => 'Mandatory assessment on phishing identification, password hygiene, SWIFT security controls, and branch workstation safety.',
                'passing_score' => 80,
                'time_limit' => 20,
            ]
        );

        QuizQuestion::where('quiz_id', $quiz3->id)->delete();
        $questionsData3 = [
            [
                'question' => 'An email arrives in your inbox titled "Urgent: Reset PBZ Core Banking Password" with an external link. What is the correct protocol?',
                'options' => [
                    'Click the link and test your current password to verify validity',
                    'Forward the email to all branch staff to warn them',
                    'Do not click any link; report the message immediately to PBZ Cyber Security Operations (SOC)',
                    'Delete the email and take no further action'
                ],
                'correct_answer' => 2,
                'order' => 1,
            ],
            [
                'question' => 'Under PBZ Clean Desk and Clean Screen Policy, what must a branch teller do before stepping away for lunch?',
                'options' => [
                    'Turn off the monitor but leave the computer unlocked',
                    'Lock the computer screen (Win + L) and lock all physical customer account vouchers in a secure drawer',
                    'Ask an adjacent colleague to watch their terminal',
                    'Leave the terminal open if remaining inside the branch building'
                ],
                'correct_answer' => 1,
                'order' => 2,
            ],
            [
                'question' => 'What is the primary risk associated with plugging an unapproved personal USB drive into a PBZ core banking terminal?',
                'options' => [
                    'It slows down printer response time',
                    'It can introduce ransomware, keyloggers, or unauthorized exfiltration of customer banking records',
                    'It resets the monitor resolution',
                    'It changes the local keyboard layout'
                ],
                'correct_answer' => 1,
                'order' => 3,
            ],
            [
                'question' => 'What does Multi-Factor Authentication (MFA) require from a PBZ banking user?',
                'options' => [
                    'Using two different web browsers simultaneously',
                    'Providing at least two distinct authentication factors (e.g. password + hardware OTP token/biometrics)',
                    'Changing passwords every 4 hours',
                    'Entering user name in uppercase and lowercase'
                ],
                'correct_answer' => 1,
                'order' => 4,
            ],
            [
                'question' => 'What is Business Email Compromise (BEC)?',
                'options' => [
                    'When an email provider experiences a server power outage',
                    'A targeted social engineering attack where an attacker impersonates a senior executive or vendor to fraudulently redirect wire transfers',
                    'Sending promotional marketing newsletters to retail customers',
                    'Standard inter-branch email communications'
                ],
                'correct_answer' => 1,
                'order' => 5,
            ],
        ];

        foreach ($questionsData3 as $q) {
            QuizQuestion::create([
                'quiz_id' => $quiz3->id,
                'question' => $q['question'],
                'type' => 'multiple-choice',
                'options' => $q['options'],
                'correct_answer' => $q['correct_answer'],
                'order' => $q['order'],
            ]);
        }
    }

    echo "✓ Courses, Topics, Lessons, Quizzes & Questions populated successfully.\n";

    // 3. Demo Student (User ID 3) Progress & Completed Certification
    $student = User::find(3);
    if ($student && $course1) {
        // Enrollment 3 (Course 1 - AML / CFT) -> COMPLETE 100%
        $enrollment1 = Enrollment::find(3);
        if ($enrollment1) {
            // Mark all lessons completed
            foreach ($course1->topics as $top) {
                foreach ($top->lessons as $les) {
                    LessonProgress::updateOrCreate(
                        ['user_id' => $student->id, 'lesson_id' => $les->id, 'enrollment_id' => $enrollment1->id],
                        [
                            'is_completed' => true,
                            'completed_at' => now()->subDays(2),
                            'progress_percentage' => 100,
                            'last_accessed_at' => now()->subDays(1),
                        ]
                    );
                }
            }

            // Quiz Attempt Passed 100%
            if (isset($quiz1)) {
                $attempt = QuizAttempt::updateOrCreate(
                    ['user_id' => $student->id, 'quiz_id' => $quiz1->id, 'enrollment_id' => $enrollment1->id],
                    [
                        'score' => 100,
                        'passed' => true,
                        'time_taken' => 640,
                        'started_at' => now()->subDays(2)->subMinutes(15),
                        'completed_at' => now()->subDays(2),
                    ]
                );

                // Add answers
                foreach ($quiz1->questions as $quest) {
                    QuizAttemptAnswer::updateOrCreate(
                        ['quiz_attempt_id' => $attempt->id, 'question_id' => $quest->id],
                        [
                            'selected_answer' => $quest->correct_answer,
                            'is_correct' => true,
                        ]
                    );
                }
            }

            // Assignment Submission Graded
            if (isset($assignment1)) {
                AssignmentSubmission::updateOrCreate(
                    ['user_id' => $student->id, 'assignment_id' => $assignment1->id, 'enrollment_id' => $enrollment1->id],
                    [
                        'submission_text' => "CONFIDENTIAL // INTERNAL SUSPICIOUS TRANSACTION REPORT (STR)\nTO: Chief Compliance & Risk Officer, People's Bank of Zanzibar\nFROM: Operations Supervisor (Demo Student), PBZ Forodhani Branch\nDATE: " . now()->subDays(3)->format('Y-m-d') . "\nSUBJECT: STR Filing - Unusual Cash Structuring & High-Velocity Deposits\n\n1. INCIDENT OVERVIEW:\nOn Tuesday morning, an individual presenting credentials as an agent for a newly incorporated trading entity attempted a cash deposit of TZS 95,000,000 in unstructured bundles. The entity has no prior commercial footprint in Zanzibar.\n\n2. RED FLAGS IDENTIFIED (BOT DIRECTIVES):\n- Refusal to furnish verifiable invoices or Bill of Lading documentation.\n- Inconsistent declarations regarding origin of capital.\n- Account opened less than 14 business days ago with minimal turnover.\n\n3. IMMEDIATE ACTIONS TAKEN:\n- Counter transaction held in accordance with PBZ standard AML operating procedures.\n- Customer screening against consolidated UN & East African Community Sanctions Lists completed (Negative).\n- Escalated to Branch Compliance Desk without tipping off customer.\n\n4. RECOMMENDATION:\nFormal filing of STR to the Financial Intelligence Unit (FIU) Tanzania within statutory 24-hour window.",
                        'submitted_at' => now()->subDays(3),
                        'status' => AssignmentSubmission::STATUS_GRADED,
                        'grade' => 96,
                        'instructor_notes' => 'Outstanding analysis. Demonstrates comprehensive mastery of Bank of Tanzania Anti-Money Laundering Regulations and PBZ internal escalation procedures.',
                    ]
                );
            }

            // Update enrollment to completed with certificate
            $enrollment1->status = Enrollment::STATUS_COMPLETED;
            $enrollment1->updated_at = now()->subDays(1);
            $enrollment1->save();

            echo "✓ Demo Student completed Course 1 with 100% progress and Certificate CERT-000003-C16A53.\n";
        }

        // Enrollment 4 (Course 2 - Amana) -> In Progress
        $enrollment2 = Enrollment::find(4);
        if ($enrollment2 && $course2) {
            $lessons = $course2->topics->flatMap->lessons;
            foreach ($lessons->take(2) as $l) {
                LessonProgress::updateOrCreate(
                    ['user_id' => $student->id, 'lesson_id' => $l->id, 'enrollment_id' => $enrollment2->id],
                    [
                        'is_completed' => true,
                        'completed_at' => now()->subDays(1),
                        'progress_percentage' => 100,
                        'last_accessed_at' => now(),
                    ]
                );
            }
            $enrollment2->status = Enrollment::STATUS_APPROVED;
            $enrollment2->save();
            echo "✓ Course 2 in-progress lessons marked.\n";
        }

        // Enrollment 5 (Course 3 - Cyber) -> In Progress
        $enrollment3 = Enrollment::find(5);
        if ($enrollment3 && $course3) {
            $firstLesson = $course3->topics->flatMap->lessons->first();
            if ($firstLesson) {
                LessonProgress::updateOrCreate(
                    ['user_id' => $student->id, 'lesson_id' => $firstLesson->id, 'enrollment_id' => $enrollment3->id],
                    [
                        'is_completed' => true,
                        'completed_at' => now()->subHours(6),
                        'progress_percentage' => 100,
                        'last_accessed_at' => now(),
                    ]
                );
            }
            $enrollment3->status = Enrollment::STATUS_APPROVED;
            $enrollment3->save();
            echo "✓ Course 3 in-progress lessons marked.\n";
        }
    }

    // 4. Bundles (Learning Tracks)
    DB::table('bundle_courses')->delete();
    Bundle::query()->forceDelete();

    $bundle1 = Bundle::create([
        'vendor_id' => 2,
        'title' => 'PBZ Certified Compliance & Cyber Risk Specialist (CCCRS) Track',
        'description' => 'Executive 2-course diploma program combining the Bank of Tanzania (BOT) AML/CFT regulatory directives with advanced banking cyber threat defense and anti-phishing hygiene.',
        'featured_image' => 'bundles/bundle-compliance.svg',
        'price' => 350000.00,
        'status' => 'active',
        'approval_status' => 'approved',
    ]);
    if ($course1 && $course3) {
        $bundle1->courses()->sync([$course1->id, $course3->id]);
    }

    $bundle2 = Bundle::create([
        'vendor_id' => 2,
        'title' => 'PBZ Amana Islamic Banking & Finance Professional Diploma',
        'description' => 'Comprehensive specialization covering Shariah-compliant retail and commercial banking, Murabaha asset acquisition, Ijara leasing structures, and BOT Shariah governance regulations.',
        'featured_image' => 'bundles/bundle-amana.svg',
        'price' => 280000.00,
        'status' => 'active',
        'approval_status' => 'approved',
    ]);
    if ($course2) {
        $bundle2->courses()->sync([$course2->id]);
    }
    echo "✓ 2 PBZ Professional Bundles created with course links.\n";

    // 5. Reviews
    Review::query()->delete();
    $reviewsData = [
        [
            'course_id' => 1,
            'user_id' => 3,
            'rating' => 5,
            'comment' => 'Exceptional training! The branch cash structuring scenarios and BOT AML directives gave our front-office tellers concrete tools to detect smurfing without tipping off clients. Highly recommended for all PBZ staff.',
            'is_approved' => true,
        ],
        [
            'course_id' => 1,
            'user_id' => 4,
            'rating' => 5,
            'comment' => 'The modules on Politically Exposed Persons (PEPs) and the practical STR memo drafting accurately mirror Bank of Tanzania inspection requirements. Very impactful.',
            'is_approved' => true,
        ],
        [
            'course_id' => 2,
            'user_id' => 3,
            'rating' => 5,
            'comment' => 'PBZ Amana is growing rapidly across Zanzibar and Pemba. This course clarified the exact legal and Shariah distinction between conventional interest and genuine asset-backed Murabaha profit margins.',
            'is_approved' => true,
        ],
        [
            'course_id' => 2,
            'user_id' => 4,
            'rating' => 5,
            'comment' => 'Superb guidance from Dr. Amina Salim. The explanation of the Shariah Board audit protocols gave me total confidence when advising corporate trade clients at Malindi Branch.',
            'is_approved' => true,
        ],
        [
            'course_id' => 3,
            'user_id' => 3,
            'rating' => 5,
            'comment' => 'Crucial for every bank employee. The simulated spear-phishing examples and Clean Desk protocols should be mandatory onboarding for all 34 PBZ branches.',
            'is_approved' => true,
        ],
        [
            'course_id' => 3,
            'user_id' => 4,
            'rating' => 5,
            'comment' => 'Outstanding coverage of SWIFT CSP security and multi-factor authentication. Practical, concise, and tailored perfectly to our banking environment.',
            'is_approved' => true,
        ],
    ];

    foreach ($reviewsData as $r) {
        Review::create($r);
    }
    echo "✓ 6 PBZ authentic banking reviews seeded.\n";

    // 6. Events
    DB::table('event_speakers')->delete();
    DB::table('event_highlights')->delete();
    DB::table('event_instructor')->delete();
    DB::table('event_bookings')->delete();
    Event::query()->delete();

    $event1 = Event::create([
        'title' => 'Annual PBZ Regulatory Compliance & BOT Risk Forum 2026',
        'slug' => 'pbz-regulatory-compliance-bot-risk-forum-2026',
        'summary' => 'Premier gathering of PBZ branch managers, risk officers, and Bank of Tanzania regulators on evolving AML, sanctions, and sovereign banking frameworks.',
        'description' => '<p>The Annual PBZ Regulatory Compliance & BOT Risk Forum convenes leaders from the Bank of Tanzania (BOT), Financial Intelligence Unit (FIU), and People\'s Bank of Zanzibar to examine emerging compliance standards, automated PEP monitoring, and cross-border payment security.</p>',
        'location_description' => 'Executive Conference Hall, PBZ Training Centre, Mpirani',
        'location' => 'Zanzibar, Tanzania',
        'contact_phone' => '+255 24 223 1118',
        'contact_email' => 'academy@pbzbank.co.tz',
        'start_date' => now()->addDays(20)->toDateString(),
        'end_date' => now()->addDays(21)->toDateString(),
        'start_time' => '08:30:00',
        'end_time' => '16:30:00',
        'total_seats' => 120,
        'price' => 0.00,
        'is_published' => true,
        'featured_image' => 'events/event-bot-forum.svg',
    ]);

    EventSpeaker::create([
        'event_id' => $event1->id,
        'name' => 'Dr. Amina Khamis Salim',
        'title' => 'Head of PBZ Learning Academy & BOT Compliance Fellow',
        'bio' => 'Senior Banking Regulation Specialist at People\'s Bank of Zanzibar.',
        'position' => 1,
    ]);

    EventSpeaker::create([
        'event_id' => $event1->id,
        'name' => 'Araphat A. Haji',
        'title' => 'Managing Director & CEO, PBZ Bank',
        'bio' => 'Chief Executive Officer leading PBZ sovereign expansion and modernization.',
        'position' => 2,
    ]);

    EventHighlight::create([
        'event_id' => $event1->id,
        'title' => 'Keynote Address on 2026 BOT Commercial Banking Directives',
        'description' => 'In-depth analysis of risk-based AML assessments and regulatory capital reserves.',
        'position' => 1,
    ]);

    EventHighlight::create([
        'event_id' => $event1->id,
        'title' => 'Live Case Clinic: Real-time Cash Structuring Detection',
        'description' => 'Interactive branch teller simulation on identifying and reporting suspicious transactions.',
        'position' => 2,
    ]);

    $event2 = Event::create([
        'title' => 'PBZ Amana Masterclass: Structuring Trade Finance & Blue Economy',
        'slug' => 'pbz-amana-masterclass-trade-finance-blue-economy',
        'summary' => 'Executive workshop exploring Islamic trade instruments (Murabaha, Istisna\'a, Sukuk) to finance Zanzibar maritime, fisheries, and spice export operations.',
        'description' => '<p>Discover how PBZ Amana provides Shariah-compliant financing solutions tailored for commercial export firms, fishermen cooperatives, and maritime shipping lines across the Zanzibar archipelago.</p>',
        'location_description' => 'Baharini Ballroom, Golden Tulip Resort',
        'location' => 'Stone Town, Zanzibar',
        'contact_phone' => '+255 24 223 1119',
        'contact_email' => 'amana-academy@pbzbank.co.tz',
        'start_date' => now()->addDays(35)->toDateString(),
        'end_date' => now()->addDays(36)->toDateString(),
        'start_time' => '09:00:00',
        'end_time' => '17:00:00',
        'total_seats' => 80,
        'price' => 150000.00,
        'is_published' => true,
        'featured_image' => 'events/event-islamic-masterclass.svg',
    ]);

    EventSpeaker::create([
        'event_id' => $event2->id,
        'name' => 'Sheikh Dr. Mohamed Said',
        'title' => 'Chairman of the PBZ Shariah Advisory Board',
        'bio' => 'Distinguished scholar in Islamic commercial jurisprudence and financial ethics.',
        'position' => 1,
    ]);

    $event3 = Event::create([
        'title' => 'East Africa Cyber Resilience in Core Banking & Payments Summit',
        'slug' => 'east-africa-cyber-resilience-core-banking-summit',
        'summary' => 'Hands-on symposium addressing SWIFT CSP compliance, ransomware mitigation, and core banking threat defense for financial institutions.',
        'description' => '<p>Join regional chief information security officers (CISOs), ethical hackers, and core banking engineers to evaluate threat vectors targeting East African commercial banks and payment gateways.</p>',
        'location_description' => 'Kibo Ballroom, Hyatt Regency Kilimanjaro',
        'location' => 'Dar es Salaam, Tanzania',
        'contact_phone' => '+255 22 211 4455',
        'contact_email' => 'cyber-summit@pbzbank.co.tz',
        'start_date' => now()->addDays(50)->toDateString(),
        'end_date' => now()->addDays(51)->toDateString(),
        'start_time' => '09:00:00',
        'end_time' => '16:00:00',
        'total_seats' => 100,
        'price' => 200000.00,
        'is_published' => true,
        'featured_image' => 'events/event-cyber-summit.svg',
    ]);

    echo "✓ 3 PBZ premier events created with speakers and highlights.\n";

    DB::commit();
    echo "\n=== ALL PBZ DEMO DATA ENHANCED SUCCESSFULLY! ===\n";

} catch (\Throwable $e) {
    DB::rollBack();
    echo "ERROR during data enhancement: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}

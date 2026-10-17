<?php
$pageTitle = 'Study Materials';
$activePage = 'reviewer';
require 'includes/app_header.php';

$lessons = [
    [
        'id' => 1,
        'title' => 'Computer Systems',
        'category' => 'Computer Basics',
        'icon' => 'fa-desktop',
        'color' => 'icon-blue',
        'duration' => '8 min read',
        'description' => 'Understand the essential components of a computer system.',
        'objectives' => [
            'Identify the basic components of a computer system.',
            'Differentiate hardware and software.',
            'Explain the role of users and data.'
        ],
        'content' => [
            ['heading' => 'What is a computer system?', 'body' => 'A computer system is a combination of hardware, software, data, and people working together to process information. It accepts input, processes data, produces output, and may store the results.'],
            ['heading' => 'Hardware', 'body' => 'Hardware refers to the physical components of a computer that you can touch, such as the monitor, keyboard, motherboard, memory, and storage drive.'],
            ['heading' => 'Software', 'body' => 'Software is a collection of programs and instructions that tell a computer what to do. Examples include operating systems, web browsers, and word processors.'],
            ['heading' => 'The information-processing cycle', 'body' => 'The basic cycle consists of input, processing, output, and storage. For example, typing a calculation is input, calculating is processing, showing the answer is output, and saving the result is storage.']
        ],
        'key_points' => ['Hardware is physical equipment.', 'Software contains programs and instructions.', 'A computer processes input into useful output.']
    ],
    [
        'id' => 2,
        'title' => 'Input and Output Devices',
        'category' => 'Computer Basics',
        'icon' => 'fa-keyboard',
        'color' => 'icon-purple',
        'duration' => '7 min read',
        'description' => 'Learn how computers receive information and present results.',
        'objectives' => [
            'Recognize common input devices.',
            'Identify common output devices.',
            'Explain the difference between input and output.'
        ],
        'content' => [
            ['heading' => 'Input devices', 'body' => 'Input devices allow users to send data or instructions to a computer. Examples include a keyboard, mouse, scanner, microphone, webcam, and touchscreen.'],
            ['heading' => 'Output devices', 'body' => 'Output devices present processed information. Common examples include a monitor, printer, speakers, projector, and headphones.'],
            ['heading' => 'Devices with multiple roles', 'body' => 'Some devices perform both input and output functions. A touchscreen displays information and detects touch, while a headset may include both headphones and a microphone.']
        ],
        'key_points' => ['Keyboard: input.', 'Monitor: output.', 'Touchscreen: both input and output.']
    ],
    [
        'id' => 3,
        'title' => 'Computer Networks',
        'category' => 'Networking',
        'icon' => 'fa-network-wired',
        'color' => 'icon-green',
        'duration' => '10 min read',
        'description' => 'Review network types, networking devices, and connections.',
        'objectives' => [
            'Define a computer network.',
            'Differentiate LAN and WAN.',
            'Recognize basic networking devices.'
        ],
        'content' => [
            ['heading' => 'What is a network?', 'body' => 'A computer network connects two or more devices so they can communicate and share data or resources. Networks can use wired connections, wireless connections, or both.'],
            ['heading' => 'LAN and WAN', 'body' => 'A Local Area Network (LAN) connects devices in a limited area, such as a home, computer laboratory, or office. A Wide Area Network (WAN) covers a larger geographical area and can connect multiple local networks.'],
            ['heading' => 'Networking devices', 'body' => 'A router forwards data between networks. A switch connects devices within a local network. A modem connects a network to an internet service connection when required by the service. A wireless access point provides Wi-Fi connectivity.'],
            ['heading' => 'Network benefits', 'body' => 'Networks can support file sharing, communication, shared printers, collaboration, and access to online services. Security and proper configuration are important to protect shared resources.']
        ],
        'key_points' => ['LAN covers a limited area.', 'WAN covers a wider area.', 'Routers and switches have different roles.']
    ],
    [
        'id' => 4,
        'title' => 'Internet Safety',
        'category' => 'Digital Literacy',
        'icon' => 'fa-shield-halved',
        'color' => 'icon-orange',
        'duration' => '6 min read',
        'description' => 'Build safer online habits and protect personal information.',
        'objectives' => [
            'Recognize common online risks.',
            'Describe good password practices.',
            'Identify suspicious messages and links.'
        ],
        'content' => [
            ['heading' => 'Protect your information', 'body' => 'Avoid sharing sensitive personal information with unknown people or untrusted websites. Review privacy settings and think carefully before posting photos, locations, or personal details.'],
            ['heading' => 'Strong passwords', 'body' => 'Use long, unique passwords or passphrases for different accounts. A password manager can help store them securely. Enable multifactor authentication when available.'],
            ['heading' => 'Phishing', 'body' => 'Phishing is an attempt to trick people into revealing information or opening malicious links. Check the sender and website address carefully. Do not open unexpected attachments or provide passwords through suspicious links.'],
            ['heading' => 'Responsible online behavior', 'body' => 'Communicate respectfully, verify information before sharing it, respect copyright, and report online abuse or suspicious activity to an appropriate trusted person or service.']
        ],
        'key_points' => ['Use unique passwords.', 'Verify links and senders.', 'Think before sharing personal information.']
    ],
    [
        'id' => 5,
        'title' => 'Basic HTML',
        'category' => 'Web Development',
        'icon' => 'fa-code',
        'color' => 'icon-purple',
        'duration' => '9 min read',
        'description' => 'Learn the basic structure of a webpage using HTML.',
        'objectives' => [
            'Explain the purpose of HTML.',
            'Recognize common HTML elements.',
            'Understand opening and closing tags.'
        ],
        'content' => [
            ['heading' => 'What is HTML?', 'body' => 'HTML stands for HyperText Markup Language. It defines the structure and content of webpages using elements represented by tags. HTML is a markup language, not a programming language.'],
            ['heading' => 'Basic document structure', 'body' => 'A typical HTML document includes a doctype declaration, an html element, a head section for metadata, and a body section for visible page content.'],
            ['heading' => 'Common elements', 'body' => 'The h1 element represents a main heading, p represents a paragraph, a creates a link, img embeds an image, and ul with li elements creates an unordered list.'],
            ['heading' => 'Attributes', 'body' => 'Attributes provide additional information about elements. For example, the href attribute specifies the destination of a link, while src specifies the source of an image.']
        ],
        'key_points' => ['HTML structures webpage content.', 'Elements use tags.', 'Attributes provide additional information.']
    ],
    [
        'id' => 6,
        'title' => 'Operating Systems',
        'category' => 'Software',
        'icon' => 'fa-gears',
        'color' => 'icon-teal',
        'duration' => '8 min read',
        'description' => 'Discover how operating systems manage computer resources.',
        'objectives' => [
            'Define an operating system.',
            'Describe common operating-system functions.',
            'Recognize desktop and mobile operating systems.'
        ],
        'content' => [
            ['heading' => 'What is an operating system?', 'body' => 'An operating system is system software that manages computer hardware and provides services for applications and users.'],
            ['heading' => 'Main functions', 'body' => 'Operating systems manage processes, memory, files, devices, user accounts, and security. They also provide an interface for users to interact with the computer.'],
            ['heading' => 'Examples', 'body' => 'Microsoft Windows and macOS are common desktop operating systems. Linux distributions are used on desktops and servers. Android and iOS are mobile operating systems.'],
            ['heading' => 'Why it matters', 'body' => 'Without an operating system, most users would have difficulty running applications and managing computer hardware. The operating system coordinates resources so applications can function.']
        ],
        'key_points' => ['The OS manages hardware resources.', 'It supports applications.', 'Windows, Linux, Android, and iOS are examples.']
    ]
];

$categories = array_values(array_unique(array_column($lessons, 'category')));
?>

<div class="page-heading">
    <div>
        <h1>Study Materials</h1>
        <p>Read concise lessons, review key concepts, and strengthen your understanding.</p>
    </div>
    <div class="icon-box icon-blue d-none d-sm-grid">
        <i class="fa-solid fa-book-open-reader"></i>
    </div>
</div>

<div class="welcome-banner mb-4" style="padding:22px 25px">
    <div class="welcome-content">
        <div class="welcome-eyebrow"><i class="fa-solid fa-bookmark"></i> YOUR REVIEW LIBRARY</div>
        <h2 style="font-size:23px">Learn at your own pace.</h2>
        <p class="mb-0">Choose a topic, read the key points, and revisit the material whenever you need a refresher.</p>
    </div>
</div>

<div class="panel mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-lg-5">
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" id="lessonSearch" class="form-control" placeholder="Search lessons or keywords..." aria-label="Search lessons">
            </div>
        </div>
        <div class="col-lg-7">
            <div class="d-flex flex-wrap gap-2" id="categoryFilters">
                <button type="button" class="filter-btn active" data-category="all">All topics</button>
                <?php foreach ($categories as $category): ?>
                    <button type="button" class="filter-btn" data-category="<?= htmlspecialchars($category, ENT_QUOTES) ?>">
                        <?= htmlspecialchars($category) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <span class="small-label"><i class="fa-solid fa-layer-group me-1"></i> <?= count($lessons) ?> lessons available</span>
        <span class="small-label">Select a lesson to begin</span>
    </div>
</div>

<div class="row g-3" id="lessonGrid">
    <?php foreach ($lessons as $lesson): ?>
        <?php
        $searchText = strtolower(
            $lesson['title'] . ' ' . $lesson['category'] . ' ' .
            $lesson['description'] . ' ' . implode(' ', $lesson['key_points'])
        );
        ?>
        <div class="col-md-6 col-xl-4 lesson-item" data-category="<?= htmlspecialchars($lesson['category'], ENT_QUOTES) ?>" data-search="<?= htmlspecialchars($searchText, ENT_QUOTES) ?>">
            <article class="lesson-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="icon-box <?= htmlspecialchars($lesson['color']) ?>">
                        <i class="fa-solid <?= htmlspecialchars($lesson['icon']) ?>"></i>
                    </div>
                    <span class="topic-tag"><?= htmlspecialchars($lesson['category']) ?></span>
                </div>

                <h3><?= htmlspecialchars($lesson['title']) ?></h3>
                <p><?= htmlspecialchars($lesson['description']) ?></p>

                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <span class="lesson-meta">
                        <i class="fa-regular fa-clock me-1"></i>
                        <?= htmlspecialchars($lesson['duration']) ?>
                    </span>
                    <button type="button" class="btn btn-sm btn-primary open-lesson" data-lesson="<?= (int) $lesson['id'] ?>">
                        Read lesson <i class="fa-solid fa-arrow-right ms-1"></i>
                    </button>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
</div>

<div id="noLessons" class="panel empty-state mt-3 d-none">
    <i class="fa-solid fa-magnifying-glass d-block"></i>
    <h3 class="section-title mb-2">No lessons found</h3>
    <p class="mb-0">Try another search term or select a different category.</p>
</div>

<div class="modal fade" id="lessonModal" tabindex="-1" aria-labelledby="lessonModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <div class="topic-tag mb-2" id="lessonCategory">Study material</div>
                    <h2 class="modal-title fs-5" id="lessonModalTitle">Lesson title</h2>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="lessonModalBody"></div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-light-blue" data-bs-dismiss="modal">Close lesson</button>
            </div>
        </div>
    </div>
</div>

<script>
    const lessonData = <?= json_encode($lessons, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    let activeCategory = 'all';

    function filterLessons() {
        const term = $('#lessonSearch').val().trim().toLowerCase();
        let visibleCount = 0;

        $('.lesson-item').each(function () {
            const category = String($(this).data('category'));
            const searchText = String($(this).data('search'));
            const categoryMatches = activeCategory === 'all' || category === activeCategory;
            const searchMatches = searchText.includes(term);
            const show = categoryMatches && searchMatches;

            $(this).toggleClass('d-none', !show);
            if (show) visibleCount++;
        });

        $('#noLessons').toggleClass('d-none', visibleCount > 0);
    }

    $('#lessonSearch').on('input', filterLessons);

    $('#categoryFilters').on('click', '.filter-btn', function () {
        activeCategory = String($(this).data('category'));
        $('#categoryFilters .filter-btn').removeClass('active');
        $(this).addClass('active');
        filterLessons();
    });

    $('.open-lesson').on('click', function () {
        const id = Number($(this).data('lesson'));
        const lesson = lessonData.find(item => Number(item.id) === id);

        if (!lesson) return;

        $('#lessonModalTitle').text(lesson.title);
        $('#lessonCategory').text(lesson.category);

        const body = $('<div>');

        $('<p>').text(lesson.description).addClass('text-secondary').appendTo(body);

        $('<h3>').text('Learning objectives').addClass('fs-6 fw-bold mt-4').appendTo(body);
        const objectives = $('<ul class="ps-3">');
        lesson.objectives.forEach(item => $('<li>').text(item).addClass('mb-1').appendTo(objectives));
        body.append(objectives);

        lesson.content.forEach(section => {
            $('<h3>').text(section.heading).addClass('fs-6 fw-bold mt-4').appendTo(body);
            $('<p>').text(section.body).addClass('mb-2').appendTo(body);
        });

        $('<h3>').text('Key points to remember').addClass('fs-6 fw-bold mt-4').appendTo(body);
        const keyPoints = $('<ul class="ps-3">');
        lesson.key_points.forEach(item => $('<li>').text(item).addClass('mb-2').appendTo(keyPoints));
        body.append(keyPoints);

        $('#lessonModalBody').empty().append(body.children());
        bootstrap.Modal.getOrCreateInstance(document.getElementById('lessonModal')).show();
    });
</script>

<?php require 'includes/app_footer.php'; ?>
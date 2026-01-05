-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 10:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `course_recommender_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(50) NOT NULL,
  `Instructor_name` varchar(100) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `short_intro` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `name`, `description`, `duration`, `Instructor_name`, `category`, `image_path`, `short_intro`) VALUES
(1, 'Web Development', 'Web development is the process of designing, building, and maintaining websites and web applications that run on the internet. It involves front-end development (what users see) using HTML, CSS, and JavaScript, and back-end development (server-side logic and databases) using languages like PHP, Python, Java, or Node.js. Web development is essential in today’s digital world as almost every business, service, and platform requires a strong online presence to reach customers and provide seamless experiences.\r\n\r\nThe field offers various roles such as front-end developer, back-end developer, full-stack developer, and web designer. It is widely used in e-commerce, education, healthcare, entertainment, and nearly every industry. With increasing demand for digital services, skilled web developers are highly sought after. In India, a fresher can expect a salary starting from ₹4–6 LPA, and with experience, it can go up to ₹15 LPA or more. Globally, salaries are even higher.\r\n\r\nTop tech companies like Google, Infosys, TCS, Wipro, Accenture, Zoho, and many startups regularly hire web developers. Learning web development opens the door to freelancing, remote work, and entrepreneurship, making it a flexible and future-proof career option. With continuous learning, developers can grow quickly in this dynamic and ever-evolving field.\r\n', '20 weeks approx', 'Mr.Prabhu', 'Development', 'images/web.jpg', 'Learn to create modern, responsive websites and web apps.'),
(2, 'Cybersecurity', 'Cybersecurity is the practice of safeguarding computer systems, networks, and data from unauthorized access, disruption, or theft. \r\n\r\nIt spans defensive measures such as firewalls and encryption, proactive tasks like threat hunting and penetration testing, and governance frameworks that ensure compliance with laws and standards. In an era of cloud computing, IoT devices, and AI‑driven services, robust cybersecurity is indispensable: it prevents financial losses, preserves privacy, and maintains trust in digital infrastructure. \r\n\r\nCareer paths include security analyst, ethical hacker, incident responder, SOC engineer, and security architect. In India, entry‑level professionals typically earn ₹5–8 lakh per annum, mid‑level specialists command ₹12–25 lakh, and experienced architects or managers can exceed ₹35 lakh; globally, salaries range from US $70 k for juniors to well over US $150 k for senior roles. Demand is strong across every sector, with top employers including technology giants (Google, Microsoft, Amazon, IBM), cybersecurity leaders (Palo Alto Networks, CrowdStrike, Check Point, Fortinet), consulting and service firms (Accenture, Deloitte, PwC, Infosys, TCS), banks (J.P. Morgan, HSBC), and government or defense organizations.\r\n\r\nCompleting a comprehensive cybersecurity course equips you with hands‑on skills and globally recognized certifications (CompTIA Security+, CEH, CISSP), opening doors to high‑impact, future‑proof careers in a rapidly growing field.', '10 weeks approx', 'Mr.Nitesh', 'Security', 'images/cyber.jpg', 'Master the skills to protect systems and data against cyber threats.'),
(3, 'Machine Learning', 'Machine learning is a branch of artificial intelligence that enables computers to learn patterns from data and improve their performance on tasks—such as classification, prediction, and recommendation—without being explicitly programmed.\r\n\r\nBy training models on historical information, machine learning powers everyday technologies including spam filters, voice assistants, fraud‑detection systems, medical diagnostics, and personalized shopping engines, making processes faster, smarter, and more accurate. Because data drives decision‑making across every sector, the demand for machine‑learning expertise is soaring. In India, entry‑level machine‑learning engineers typically earn ₹6–10 lakh per annum, while professionals with three to five years of experience command ₹15–25 lakh; globally, mid‑career salaries often exceed US \\$120,000. \r\n\r\nCompleting a solid machine‑learning course can open doors at technology giants like Google, Amazon, Microsoft, Apple, and Meta; AI‑focused firms such as OpenAI, DeepMind, and NVIDIA; and consulting leaders like Accenture, Deloitte, and McKinsey. Additionally, data‑driven startups in fintech, health‑tech, ed‑tech, and autonomous vehicles aggressively recruit machine‑learning talent, offering stock options and remote‑first flexibility. \r\n\r\nFreelancing platforms and research labs also provide viable career paths. Continuous upskilling in programming (Python or R), mathematics (linear algebra, probability, optimization), and frameworks (TensorFlow, PyTorch, scikit‑learn) will keep you competitive in this rapidly evolving, high‑impact field.', '1 month approx or more', 'Mr.Nitesh', 'Artificial Intelligence', 'images/ML.jpg', 'Learn how machines make predictions and decisions from data using algorithms.'),
(4, 'Cloud Computing', 'Cloud computing is the on‑demand delivery of computing resources—servers, storage, databases, networking, analytics, and AI—over the internet, allowing organizations to scale quickly without investing in physical infrastructure. \r\n\r\nBy shifting to cloud platforms such as Amazon Web Services (AWS), Microsoft Azure, and Google Cloud, businesses gain agility, pay‑as‑you‑go cost savings, global availability, and built‑in security, powering everything from streaming services and e‑commerce sites to real‑time data analytics and IoT deployments. \r\n\r\nThis ubiquity fuels strong demand for cloud architects, DevOps engineers, site‑reliability engineers, and security specialists. In India, cloud‑computing professionals typically start at ₹5–8 lakh per annum; with three to five years of experience, earnings rise to ₹15–25 lakh, and senior architects often exceed ₹30 lakh. Globally, mid‑career roles average US \\$120,000–150,000, with top experts earning much more. \r\n\r\nCompleting a comprehensive cloud‑computing course—covering virtualization, containerization (Docker, Kubernetes), serverless functions, CI/CD pipelines, and cost‑optimization—opens career opportunities at hyperscale providers like AWS, Microsoft, and Google; consulting and IT service leaders such as Accenture, Infosys, TCS, and Cognizant; and cloud‑native innovators including Salesforce, Snowflake, VMware, Atlassian, and a multitude of fintech, health‑tech, and AI startups. \r\n\r\nContinuous certification (AWS, Azure, GCP) and hands‑on lab work are key to thriving in this fast‑growing, high‑impact field.', '20 weeks approx', 'Mrs.Jenny', 'Cloud Technology', 'images/cloud.jpg', 'Master on‑demand cloud technologies to build, deploy, and scale applications seamlessly.'),
(5, 'Database Management Systems', 'A Database Management System (DBMS) is software that enables users to create, store, organize, retrieve, and safeguard large volumes of structured data while enforcing consistency, security, and concurrency.\r\n\r\nInstead of scattered spreadsheets, a DBMS—such as MySQL, PostgreSQL, Oracle, or Microsoft SQL Server—offers centralized control through powerful query languages (SQL) and transactional guarantees, making it indispensable for banking ledgers, e‑commerce catalogs, hospital records, and virtually every data‑driven application.\r\n\r\nMastering DBMS concepts—data models, normalization, indexing, ACID transactions, backup, replication, and performance tuning—translates directly into business value: faster analytics, reliable reporting, and resilient, scalable systems. Consequently, demand for database administrators (DBAs), data engineers, and backend developers remains high.\r\n\r\nIn India, entry‑level DBMS professionals earn around ₹4–7 lakh per annum; with three to five years of experience, pay typically rises to ₹10–18 lakh, while senior architects can exceed ₹25 lakh. Globally, mid‑career roles average US \\$100,000–130,000.\r\n\r\nCompleting a robust DBMS course opens doors at technology giants (Oracle, Microsoft, Amazon, Google), IT services leaders (TCS, Infosys, Wipro, Accenture), financial institutions (JPMorgan Chase, Goldman Sachs), and data‑centric startups in fintech, health‑tech, and analytics.\r\n\r\nContinuous learning in cloud databases, NoSQL, and automation tools keeps you competitive in this essential, ever‑evolving field.\r\n', '1-2 months approx', 'Mr.Prabhu', 'Database', 'images/DBMS.jpg', 'Learn to design, manage, and optimize databases that power modern applications.'),
(6, 'Software Development', 'Software development is the systematic process of designing, coding, testing, and maintaining programs that solve real‑world problems—from mobile banking apps and e‑commerce platforms to embedded systems in cars.\r\n\r\nUsing languages such as Java, Python, C++, and JavaScript, developers turn ideas into reliable, scalable products that streamline operations, boost productivity, and create new digital experiences. Because software underpins every industry, skilled developers are in constant demand.\r\n\r\nIn India, fresh graduates generally start at ₹5–8 lakh per annum; with three to five years of experience, salaries reach ₹12–20 lakh, and seasoned engineers or technical leads can earn ₹25 lakh or more. Globally, mid‑career roles often command US \\$110,000–140,000, with higher compensation in tech hubs.\r\n\r\nCompleting a comprehensive software‑development course—covering algorithms, data structures, version control, agile practices, cloud deployment, and DevOps—opens career paths at tech giants like Google, Microsoft, Amazon, Apple, and Meta; leading IT service firms such as Infosys, TCS, Wipro, and Accenture; and high‑growth startups in fintech, health‑tech, gaming, and AI.\r\n\r\nFreelancing and remote work provide additional flexibility and income potential. Continuous upskilling in emerging frameworks, cloud platforms, and AI integration keeps software developers at the forefront of innovation in this dynamic, high‑impact field.', '20 weeks approx ', 'Mr.Laxman', 'Development', 'images/SE.jpg', 'Learn to design, build, and maintain software that powers modern digital solutions.'),
(7, 'Artificial Intelligence', 'Artificial Intelligence (AI) is the field of computer science that builds systems capable of performing tasks that normally require human intelligence—perception, language understanding, reasoning, and autonomous decision‑making.\r\n\r\nBy learning from massive datasets, AI models power voice assistants, recommender engines, real‑time language translation, autonomous vehicles, predictive maintenance, and advanced medical diagnostics, dramatically improving speed, accuracy, and personalization across industries. \r\n\r\nBecause data‑driven insights translate directly into competitive advantage, demand for AI talent is soaring. In India, entry‑level AI engineers earn about ₹8–12 lakh per annum, while professionals with three to five years of experience command ₹20–35 lakh; senior researchers and architects often exceed ₹45 lakh.\r\n\r\nInternationally, mid‑career AI roles average US \\$130,000–170,000, and top experts at leading labs receive far higher packages plus equity.\r\n\r\nCompleting a rigorous AI course—covering machine learning, deep learning, natural‑language processing, computer vision, MLOps, and ethical AI—opens doors at global technology giants such as Google, Microsoft, Amazon, Apple, Meta, and NVIDIA; cutting‑edge research organizations like OpenAI, DeepMind, and Anthropic; consulting leaders including Accenture and Deloitte; and AI‑first startups in fintech, health‑tech, robotics, and climate tech.\r\n\r\nContinuous mastery of Python, TensorFlow or PyTorch, large‑scale data engineering, and responsible‑AI practices keeps professionals at the forefront of this transformative, high‑impact discipline.', '7-8 weeks approx', 'Mr.Jenny ', 'Artificial Intelligence', 'images/AI.jpg', 'Dive deep into creating intelligent systems that mimic human reasoning'),
(8, 'Blockchain Technology', 'Blockchain technology is a decentralized, tamper‑resistant ledger that records transactions across a network of computers, eliminating the need for a central authority and ensuring transparency, security, and immutability.\r\n\r\nBy chaining cryptographically linked blocks of data, blockchain underpins cryptocurrencies such as Bitcoin and Ethereum, but its utility extends far beyond digital money. Enterprises use blockchain for supply‑chain provenance, cross‑border payments, smart contracts, digital identity, and secure IoT data sharing, reducing fraud and streamlining multi‑party processes.\r\n\r\nAs organizations seek trustless, auditable systems, demand for blockchain developers, solution architects, and smart‑contract engineers has surged. In India, entry‑level blockchain professionals typically start at ₹6–10 lakh per annum; with three to five years of experience, salaries rise to ₹18–28 lakh, while senior architects can surpass ₹35 lakh.\r\n\r\nGlobally, mid‑career roles often earn US \\$120,000–160,000, and experienced specialists at major exchanges or DeFi platforms command even higher packages plus token incentives. Completing a focused blockchain‑technology course—covering distributed‑ledger fundamentals, consensus algorithms, Solidity smart‑contract development, tokenomics, Layer‑2 scaling, and security audits—opens career paths at crypto giants (Coinbase, Binance, Ripple), tech leaders (IBM, Microsoft, Amazon Web Services), consulting firms (Accenture, Deloitte, EY), and a vibrant ecosystem of Web3 startups building decentralized finance (DeFi), NFTs, and enterprise blockchains.\r\n\r\nContinuous learning in emerging protocols and regulatory landscapes keeps professionals competitive in this rapidly evolving domain.', '15-14 weeks approx', 'Mr.Nitesh', 'Blockchain', 'images/BC.jpg', 'Learn the principles and applications of decentralized ledgers'),
(9, 'Network Administration', 'Network Administration is the practice of planning, deploying, securing, and optimizing the data‑communication infrastructure that connects an organization’s computers, servers, cloud resources, and IoT devices.\r\n\r\nNetwork administrators configure routers, switches, firewalls, VLANs, Wi‑Fi, VPNs, and monitoring tools to ensure reliable, high‑speed connectivity and protect against cyber‑threats.\r\n\r\nTheir work underpins everyday operations—from email and video calls to ERP systems and hybrid‑cloud workloads—making fast troubleshooting and 24 × 7 availability critical for productivity and revenue. Because every modern enterprise depends on resilient networks, skilled administrators remain in steady demand.\r\n\r\nIn India, entry‑level roles such as Network Support Engineer or Junior Administrator start around ₹3.5–6 lakh per annum; with three to five years of experience and certifications like CCNA, CompTIA Network+, or JNCIA, salaries typically rise to ₹9–15 lakh, while senior network or systems engineers can exceed ₹20 lakh.\r\n\r\nGlobally, mid‑career professionals average US \\$80,000–110,000, and specialized architects in large data‑center or cloud environments command higher packages.\r\n\r\nCompleting a comprehensive Network Administration course—covering TCP/IP fundamentals, subnetting, routing protocols (OSPF, BGP), network automation, SD‑WAN, and security hardening—opens career paths at telecom giants (Cisco, Juniper Networks), cloud providers (Amazon Web Services, Microsoft Azure, Google Cloud), IT service leaders (Infosys, TCS, Wipro), managed‑service providers, banks, and rapidly growing SaaS and e‑commerce companies.\r\n\r\nContinuous upskilling in cloud networking, Zero‑Trust security, and automation keeps professionals competitive in this mission‑critical field.\r\n', '15-20 weeks approx', 'Mr.Nitesh', 'Networking', 'images/NA.jpg', 'Understand the setup, management, and security of computer networks'),
(10, 'Data Structures and Algorithms', 'Data Structures and Algorithms (DSA) is the backbone of computer science, focusing on how data is organized (arrays, linked lists, trees, graphs, hash tables) and the step‑by‑step procedures that manipulate it (sorting, searching, dynamic programming, graph traversal).\r\n\r\nMastery of DSA enables engineers to write code that runs faster, uses less memory, and scales gracefully—crucial for everything from rendering a newsfeed in milliseconds to routing millions of ride‑share requests in real time. \r\n\r\nBecause efficient problem‑solving translates directly into better user experiences and lower infrastructure costs, strong DSA skills are among the top hiring criteria for software and product companies.\r\n\r\nIn India, graduates who demonstrate proficiency in DSA during coding interviews typically secure entry‑level software‑engineering roles at ₹8–12 lakh per annum; with three to five years of experience, compensation rises to ₹18–30 lakh, and senior or staff engineers often exceed ₹40 lakh plus stock options.\r\n\r\nGlobally, mid‑career engineers at leading tech firms average US \\$130,000–180,000. Completing a rigorous DSA course—covering time and space complexity, recursion, greedy and divide‑and‑conquer techniques, and competitive‑programming style problem‑solving—opens doors at product giants like Google, Amazon, Microsoft, Apple, and Meta; fast‑growing startups such as Flipkart, Swiggy, and Zoho; fintech leaders like JPMorgan Chase and PayPal; and specialized algorithm‑heavy domains including cybersecurity, gaming, and high‑frequency trading.\r\n\r\nContinuous practice on coding platforms and participation in hackathons keep professionals sharp in this foundational, high‑impact discipline.', '10 weeks approx', 'Mrs.Rakshu', 'Computer Science', 'images/DSA.jpg', 'Learn efficient ways to organize and manipulate data'),
(11, 'Operating Systems', 'An Operating System (OS) is the core software layer that manages computer hardware and provides essential services—process scheduling, memory allocation, file‑system management, device control, and security abstractions—allowing applications to run smoothly without needing to handle low‑level details.\r\n\r\nWhether on laptops, smartphones, cloud servers, or embedded IoT devices, OSs like Linux, Windows, macOS, Android, and real‑time kernels orchestrate CPU time‑slicing, multitasking, virtualization, and power management, ensuring reliability and optimal performance.\r\n\r\nUnderstanding OS internals—process synchronization, paging, I/O buffering, kernel modules, and system calls—empowers engineers to write efficient code, debug performance bottlenecks, and design secure, scalable platforms. \r\n\r\nConsequently, roles such as systems engineer, kernel developer, and site‑reliability engineer (SRE) remain highly valued. \r\n\r\nIn India, entry‑level OS or systems developers typically earn ₹6–10 lakh per annum; with three to five years of specialized experience, salaries rise to ₹18–28 lakh, while senior kernel or performance engineers can exceed ₹35 lakh plus equity.\r\n\r\nInternationally, mid‑career professionals often command US \\$120,000–160,000, with higher packages at top tech firms.\r\n\r\nCompleting an in‑depth Operating Systems course—covering concurrency, virtualization, file‑system design, containerization, and security hardening—opens career paths at giants like Google, Microsoft, Apple, Amazon, and Red Hat; cloud providers (AWS, Azure, Google Cloud); chipset makers (Intel, AMD, NVIDIA); cybersecurity firms; and high‑performance computing or embedded‑systems startups.\r\n\r\nContinuous learning in container orchestration, eBPF, and real‑time OSs keeps professionals at the forefront of this foundational, mission‑critical field.', '10-12 weeks', 'Mr.Nitesh', 'Computer Science', 'images/OP.jpg', 'Learn how modern operating systems work and manage hardware resource'),
(12, 'UI/UX Design\r\n\r\n', 'UI/UX Design combines User Interface (visual layout) and User Experience (interaction flow) to create digital products that are not only attractive but also intuitive, accessible, and delightful to use.\r\n\r\nUI focuses on typography, color, iconography, and responsive layouts, while UX maps research‑driven user journeys, wireframes, and prototypes to solve real problems with minimal friction.\r\n\r\nEffective UI/UX boosts engagement, conversion rates, and brand loyalty, making it indispensable for websites, mobile apps, SaaS dashboards, wearables, and emerging AR/VR experiences.\r\n\r\nAs businesses compete on customer experience, demand for UI/UX designers has surged. In India, entry‑level designers typically earn ₹4–8 lakh per annum; with three to five years of experience, pay rises to ₹12–20 lakh, and seasoned design leads or product designers can exceed ₹25 lakh plus stock options.\r\n\r\nGlobally, mid‑career roles average US \\$90,000–120,000, with higher compensation in tech hubs.\r\n\r\nCompleting a comprehensive UI/UX Design course—covering user research, design thinking, information architecture, Figma or Adobe XD prototyping, usability testing, and accessibility standards—opens career paths at product giants like Google, Apple, Microsoft, and Meta; leading consultancies such as Accenture Song and Deloitte Digital; design‑centric startups like Airbnb, Canva, and Figma; and a broad range of fintech, e‑commerce, and health‑tech companies eager to craft seamless digital experiences.\r\n\r\nContinuous learning in design systems, motion design, and human‑AI interaction keeps professionals competitive in this creative, high‑impact field.\r\n', '1 months approx', 'Mr.Pushpanathan', 'Design', 'images/UIUX.jpg', 'Understand the principles of user interface and user experience design'),
(13, 'Ethical Hacking\r\n', 'Ethical Hacking—also called penetration testing or white‑hat hacking—is the authorized practice of probing computer systems, networks, web apps, and mobile devices for security weaknesses before malicious actors can exploit them.\r\n\r\nUsing the same tools and techniques as cybercriminals—vulnerability scanners, password‑cracking, social engineering, wireless attacks, and exploit development—ethical hackers uncover flaws, document proof‑of‑concept breaches, and recommend remediations, thereby strengthening an organization’s defenses and ensuring compliance with standards like ISO 27001, PCI‑DSS, and GDPR.\r\n\r\nAs ransomware and data‑breach costs soar, skilled ethical hackers have become indispensable across finance, healthcare, e‑commerce, and government. \r\n\r\nIn India, Certified Ethical Hackers (CEH) or OSCP‑qualified professionals typically start at ₹5–9 lakh per annum; with three to five years of experience in penetration testing or red‑team roles, salaries rise to ₹15–25 lakh, while senior security consultants and bug‑bounty hunters can exceed ₹30 lakh plus performance bonuses.\r\n\r\nGlobally, mid‑career ethical‑hacking roles average US \\$95,000–130,000, with higher compensation at big‑tech and critical‑infrastructure firms.\r\n\r\nCompleting a robust ethical‑hacking course—covering network reconnaissance, web‑app security, cloud penetration, reverse engineering, and report writing—opens doors at cybersecurity giants (CrowdStrike, Palo Alto Networks, Rapid7), consulting leaders (Accenture, Deloitte, EY), financial institutions (JPMorgan Chase, PayPal), cloud providers (AWS, Microsoft Azure), and specialized security startups, as well as lucrative freelance bug‑bounty platforms like HackerOne and Bugcrowd. \r\n\r\nContinuous learning in zero‑day research, cloud‑native security, and purple‑team collaboration keeps professionals competitive in this high‑impact, fast‑evolving field.\r\n', '11 weeks approx', 'Mr.Ishan', 'Security', 'images/EH.jpg', 'Learn penetration testing and legal hacking techniques to secure systems\r\n'),
(14, 'Internet of Things (IoT)', 'The Internet of Things (IoT) is an ecosystem of physical devices—sensors, wearables, appliances, vehicles, industrial machinery—embedded with connectivity, software, and analytics that let them collect data and act autonomously over the internet.\r\n\r\nBy merging real‑world telemetry with cloud intelligence, IoT enables smart homes that cut energy bills, predictive‑maintenance factories that prevent downtime, connected cars that optimize routes, and precision‑agriculture fields that boost yields while conserving water.\r\n\r\nThis fusion of hardware, edge computing, and AI transforms decision‑making, reduces costs, and unlocks new business models such as usage‑based billing and remote asset monitoring. Consequently, demand for IoT engineers, solution architects, and security specialists has accelerated.\r\n\r\nIn India, entry‑level IoT professionals typically earn ₹5–9 lakh per annum; with three to five years of experience in embedded C/C++, MQTT, and cloud platforms like AWS IoT Core or Azure IoT Hub, compensation rises to ₹15–25 lakh, while senior architects can exceed ₹30 lakh. Globally, mid‑career roles average US \\$100,000–140,000, with higher packages in industrial and automotive sectors.\r\n\r\nCompleting an end‑to‑end IoT course—covering microcontroller programming, wireless protocols (BLE, Zigbee, LoRaWAN), edge AI, digital twins, and cybersecurity—opens careers at tech giants (Amazon, Microsoft, Google, Samsung), industrial leaders (Siemens, Bosch, GE, Honeywell), telecom operators (Reliance Jio, Vodafone), and a thriving startup scene in smart‑city, health‑tech, and agritech solutions.\r\n\r\nContinuous learning in 5G, edge‑AI accelerators, and secure‑by‑design practices keeps professionals competitive in this rapidly expanding, high‑impact domain.\r\n', '6-7 weeks approx', 'Mr.Rahul', 'Embedded Systems', 'images/IOT.jpg', 'Explore the integration of sensors, devices, and networks to create smart systems'),
(15, 'Big Data Analytics', 'Big Data Analytics is the practice of processing and interpreting massive, high‑velocity, and diverse datasets—often measured in terabytes or petabytes—to uncover hidden patterns, trends, and correlations that drive smarter decisions.\r\n\r\nLeveraging distributed frameworks such as Hadoop, Spark, and cloud‑native tools like Google BigQuery or AWS EMR, analysts integrate structured logs, social‑media feeds, sensor streams, and transactional records, then apply statistical models, machine learning, and visualization to reveal customer behavior, predict equipment failure, or optimize supply chains.\r\n\r\nThese insights boost revenue, cut costs, and power personalized experiences, making big‑data skills indispensable across finance, retail, healthcare, telecom, and government.\r\n\r\nAs organizations race to become data‑driven, demand for big‑data engineers, analysts, and architects has surged. In India, entry‑level professionals typically earn ₹6–10 lakh per annum; with three to five years of experience in SQL, Python, Spark, and data‑pipeline orchestration, compensation rises to ₹18–28 lakh, while senior architects or lead data scientists can exceed ₹35 lakh plus stock options.\r\n\r\nGlobally, mid‑career roles average US \\$120,000–160,000, with higher packages at tech giants and hedge funds. Completing a comprehensive Big Data Analytics course—covering data ingestion, NoSQL, real‑time streaming, ETL, and dashboarding tools like Tableau or Power BI—opens careers at companies such as Google, Amazon, Microsoft, Netflix, JPMorgan Chase, Accenture, Deloitte, and a fast‑growing ecosystem of AI‑driven startups.\r\n\r\nContinuous learning in data‑ops, lakehouse architectures, and privacy regulations keeps professionals competitive in this high‑impact, ever‑evolving field.', '25 weeks approx', 'Mr.Jenny', 'Data Science', 'images/BD.jpg', 'Learn to process and analyze large-scale data sets for insights'),
(16, 'Agile Project Management', 'Agile Project Management is an iterative approach to delivering work that focuses on value, collaboration, and rapid adaptation to change.\r\n\r\nRooted in the Agile Manifesto, it breaks projects into small, time‑boxed increments—sprints—where cross‑functional teams plan, build, review, and refine features in a continuous feedback loop.\r\n\r\nTechniques such as Scrum ceremonies, Kanban boards, user stories, and daily stand‑ups keep priorities visible, risks small, and stakeholders engaged.\r\n\r\nBy emphasizing working software over exhaustive documentation, Agile accelerates time‑to‑market, boosts product quality, and fosters a culture of continuous improvement—benefits prized in software development but now adopted across marketing, finance, and hardware design.\r\n\r\nConsequently, certified Agile professionals (CSM, PMI‑ACP, SAFe) are in high demand. In India, entry‑level Agile project coordinators or Scrum Masters earn around ₹6–9 lakh per annum; with three to five years of experience, compensation rises to ₹12–20 lakh, and seasoned Agile coaches or release train engineers can exceed ₹28 lakh plus bonuses.\r\n\r\nGlobally, mid‑career Agile roles average US \\$100,000–130,000, with higher packages in tech hubs.\r\n\r\nCompleting a robust Agile Project Management course—covering Scrum, Kanban, Lean metrics, servant leadership, and scaled Agile frameworks—opens career paths at product giants like Google, Microsoft, and Amazon; IT services leaders such as Infosys, TCS, Wipro, and Accenture; fintech and health‑tech startups; and consulting firms helping enterprises transform digitally.\r\n\r\nContinuous learning in DevOps, value‑stream mapping, and agile scaling keeps professionals at the forefront of this dynamic, high‑impact discipline.\r\n', '10-12 weeks approx', 'Mr.Nitesh', 'Project Management', 'images/APM.jpg', 'Master agile methodologies for effective software project delivery'),
(17, 'Computer Vision', 'Computer Vision (CV) is a branch of artificial intelligence that enables machines to interpret and act on visual information—images and video—much like the human eye and brain.\r\n\r\nBy applying deep‑learning models, feature extraction, and geometric algorithms, CV systems detect objects, recognize faces, read license plates, segment medical scans, track shoppers in retail aisles, and guide autonomous drones or vehicles.\r\n\r\nThese capabilities streamline quality inspection on factory lines, enhance security through intelligent surveillance, enable contact‑less checkout, and power AR/VR experiences, making computer vision central to Industry 4.0, smart cities, and digital healthcare. Demand for CV engineers, researchers, and MLOps specialists is surging as businesses race to unlock the value of visual data.\r\n\r\nIn India, entry‑level computer‑vision professionals typically earn ₹7–12 lakh per annum; with three to five years of experience in Python, OpenCV, TensorFlow, or PyTorch, salaries rise to ₹18–30 lakh, while senior scientists or perception leads can exceed ₹40 lakh plus equity.\r\n\r\nGlobally, mid‑career roles average US \\$120,000–160,000, with higher packages in autonomous‑vehicle, robotics, and semiconductor firms. Completing a comprehensive Computer Vision course—covering convolutional neural networks (CNNs), object detection (YOLO, Faster R‑CNN), image segmentation, 3D vision, and deployment on edge devices—opens careers at tech giants like Google, Apple, Amazon, NVIDIA, and Meta; autonomous‑driving innovators such as Tesla and Waymo; healthcare AI companies; and a vibrant ecosystem of startups in retail analytics, agriculture, and robotics.\r\n\r\nContinuous learning in multimodal vision‑language models and efficient edge inference keeps professionals competitive in this fast‑evolving, high‑impact field.\r\n', '15-20 weeks approx', 'Mr.John Joe', 'Artificial Intelligence', 'images/CV.jpg', 'Study how computers interpret and process visual information'),
(18, 'Augmented and Virtual Reality (AR/VR)', 'Augmented Reality (AR) overlays digital content onto the real world, while Virtual Reality (VR) immerses users in entirely simulated 3‑D environments—together creating interactive experiences that blend physical and virtual realms.\r\n\r\nPowered by game engines (Unity, Unreal), 3‑D graphics, spatial mapping, and motion tracking, AR/VR transforms how we learn, work, and play: surgeons rehearse procedures on holographic organs, field technicians receive hands‑free repair guidance, designers walk through virtual prototypes, and gamers explore richly interactive worlds.\r\n\r\nAs hardware costs fall and 5G/edge computing reduce latency, enterprises across healthcare, manufacturing, retail, tourism, and education are investing in immersive solutions to boost training effectiveness, sales conversions, and customer engagement. This surge drives demand for AR/VR developers, 3‑D artists, interaction designers, and XR product managers.\r\n\r\nIn India, entry‑level AR/VR professionals typically earn ₹5–9 lakh per annum; with three to five years of experience in C#, C++, shaders, and spatial UX, salaries rise to ₹15–25 lakh, while senior XR engineers or technical artists can exceed ₹30 lakh plus equity.\r\n\r\nGlobally, mid‑career roles average US \\$100,000–140,000, with higher compensation at leading headset makers and game studios.\r\n\r\nCompleting a comprehensive AR/VR course—covering real‑time rendering, ARKit/ARCore, hand‑tracking, and UX best practices—opens careers at tech giants (Meta, Apple, Google, Microsoft), gaming leaders (Unity, Epic Games), enterprise‑XR providers (PTC, Accenture XR), and a vibrant startup ecosystem crafting immersive retail, training, and wellness applications. \r\n\r\nContinuous learning in mixed reality, volumetric capture, and haptic feedback keeps professionals competitive in this rapidly advancing, high‑impact field.\r\n', '24-25 weeks approx', 'Mrs.Kiara', 'Emerging Technology', 'images/ARVR.jpg', 'Learn to build immersive experiences using AR and VR technologies');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` datetime DEFAULT current_timestamp(),
  `status` enum('In Progress','completed','dropped') DEFAULT 'In Progress',
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `user_id`, `course_id`, `enrollment_date`, `status`, `rating`) VALUES
(22, 22, 1, '2026-01-05 14:39:24', 'completed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roadmaps`
--

CREATE TABLE `roadmaps` (
  `roadmap_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `step_number` int(3) NOT NULL,
  `step_title` varchar(255) NOT NULL,
  `step_description` text NOT NULL,
  `status` enum('Pending','Active','Completed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roadmaps`
--

INSERT INTO `roadmaps` (`roadmap_id`, `course_id`, `step_number`, `step_title`, `step_description`, `status`, `created_at`) VALUES
(1, 1, 1, 'HTML5: The Foundation', 'Master semantic HTML structure, proper use of tags (e.g., <header>, <article>), creating robust forms, understanding input types, and basic accessibility standards (ARIA).', 'Completed', '2025-11-03 16:06:22'),
(2, 1, 2, 'CSS3: Styling & Responsive Design', 'Deep dive into The Box Model, inheritance, and specificity. Master Flexbox and CSS Grid to create fluid, responsive layouts that adapt to all screen sizes.', 'Completed', '2025-11-03 16:06:22'),
(3, 1, 3, 'JavaScript (JS) Core', 'Learn variables, data types, operators, and control flow. Focus on functions, arrow functions, and object manipulation. Practice DOM manipulation to dynamically update the page.', 'Completed', '2025-11-03 16:06:22'),
(4, 1, 4, 'Essential Developer Tools', 'Set up your development environment (VS Code). Learn Git for version control (commits, branching, merging) and host your code on GitHub (or similar platform).', 'Completed', '2025-11-03 16:06:22'),
(5, 1, 5, 'Advanced JS & Frameworks', 'Learn modern JavaScript features (ES6+). Understand module systems. Start learning a major frontend framework like React, Vue, or Angular (focus on components and state).', 'Pending', '2025-11-03 16:06:22'),
(6, 1, 6, 'Backend Logic & Runtime', 'Choose a server-side technology (e.g., PHP or Node.js/Express). Understand how the server handles HTTP requests, basic routing, and the MVC (Model-View-Controller) architecture.', 'Pending', '2025-11-03 16:06:22'),
(7, 1, 7, 'Relational Databases (SQL)', 'Learn SQL (Structured Query Language) for interaction with a database like MySQL. Master CRUD operations (Create, Read, Update, Delete) to manage application data efficiently.', 'Pending', '2025-11-03 16:06:22'),
(8, 1, 8, 'APIs: The Communication Bridge', 'Learn how to design and build simple RESTful APIs on the backend and how to fetch and send data from the frontend using native Fetch or Axios.', 'Pending', '2025-11-03 16:06:22'),
(9, 1, 9, 'Security and Authentication', 'Implement secure user authentication (login/registration). Learn to hash passwords (e.g., using bcrypt) and manage user sessions securely to prevent common web vulnerabilities (e.g., CSRF, SQL Injection).', 'Pending', '2025-11-03 16:06:22'),
(10, 1, 10, 'Final Deployment & Portfolio', 'Successfully deploy a full-stack application to a live server (e.g., Vercel, Netlify, DigitalOcean). Build and deploy a professional portfolio website showcasing your best projects.', 'Pending', '2025-11-03 16:06:22'),
(11, 2, 1, 'Networking & Protocols (NetSec)', 'Master TCP/IP, OSI model, subnetting, and common network services (DNS, DHCP). Understand firewall types and basic network segmentation.', 'Completed', '2025-11-03 16:07:42'),
(12, 2, 2, 'Operating Systems & Virtualization', 'Gain deep proficiency in Linux/CLI and Windows security controls. Learn to use virtualization (VMware/VirtualBox) for building safe lab environments (e.g., Kali Linux).', 'Completed', '2025-11-03 16:07:42'),
(13, 2, 3, 'Security Principles & Risk Management', 'Understand the CIA Triad (Confidentiality, Integrity, Availability) and non-repudiation. Learn risk assessment methodologies and basic security policies.', 'Completed', '2025-11-03 16:07:42'),
(14, 2, 4, 'Cryptography Fundamentals', 'Master symmetric and asymmetric encryption (AES, RSA). Understand hashing (SHA-256) and digital signatures. Learn how SSL/TLS secures web traffic.', 'Completed', '2025-11-03 16:07:42'),
(15, 2, 5, 'Identity & Access Management (IAM)', 'Implement authentication methods (MFA, SSO) and authorization models (RBAC, ABAC). Understand directory services like Active Directory and LDAP.', 'Completed', '2025-11-03 16:07:42'),
(16, 2, 6, 'Threat & Vulnerability Management', 'Learn to use vulnerability scanners (e.g., Nessus, OpenVAS). Understand CVSS scoring and the patching and remediation lifecycle.', 'Pending', '2025-11-03 16:07:42'),
(17, 2, 7, 'Security Operations (SecOps)', 'Master log analysis and monitoring using SIEM tools. Practice incident response procedures, including detection, containment, and recovery phases.', 'Pending', '2025-11-03 16:07:42'),
(18, 2, 8, 'Ethical Hacking & Penetration Testing', 'Learn the stages of a penetration test (reconnaissance, scanning, exploitation, post-exploitation). Practice basic exploit techniques in a controlled lab environment.', 'Pending', '2025-11-03 16:07:42'),
(19, 2, 9, 'Web Application Security (AppSec)', 'Understand the OWASP Top 10 vulnerabilities (Injection, XSS, Broken Auth). Learn secure coding practices and using tools like Burp Suite.', 'Pending', '2025-11-03 16:07:42'),
(20, 2, 10, 'Governance, Risk & Compliance (GRC)', 'Understand major regulatory frameworks (GDPR, HIPAA, SOC 2). Learn about security audits and policy documentation.', 'Pending', '2025-11-03 16:07:42'),
(21, 3, 1, 'Python & Libraries Setup', 'Master Python fundamentals (data structures, control flow). Learn essential ML libraries: NumPy for array manipulation, Pandas for data analysis, and Matplotlib/Seaborn for visualization.', 'Completed', '2025-11-03 16:09:12'),
(22, 3, 2, 'Foundational Mathematics', 'Deep dive into Linear Algebra (vectors, matrices, eigenvalues) and Calculus (derivatives, partial derivatives, Gradient Descent). These are the math engines behind ML algorithms.', 'Completed', '2025-11-03 16:09:12'),
(23, 3, 3, 'Probability & Statistics', 'Understand core concepts: probability distributions (Gaussian, Binomial), hypothesis testing, descriptive statistics (mean, median, variance), and correlation analysis.', 'Completed', '2025-11-03 16:09:12'),
(24, 3, 4, 'Data Preprocessing & EDA', 'Learn Exploratory Data Analysis (EDA). Master techniques for data cleaning, handling missing values, feature scaling (Normalization/Standardization), and feature engineering.', 'Completed', '2025-11-03 16:09:12'),
(25, 3, 5, 'Core ML Algorithms (Supervised)', 'Understand and implement linear regression, logistic regression, and K-Nearest Neighbors (KNN). Focus on the fundamental concepts of model training and evaluation.', 'Completed', '2025-11-03 16:09:12'),
(26, 3, 6, 'Model Evaluation & Metrics', 'Learn to evaluate model performance using metrics: Accuracy, Precision, Recall, F1-Score, Confusion Matrix, and ROC Curves. Understand overfitting and cross-validation.', 'Completed', '2025-11-03 16:09:12'),
(27, 3, 7, 'Advanced Algorithms (Trees & Ensembles)', 'Study Decision Trees and ensemble methods like Random Forest and Gradient Boosting (XGBoost/LightGBM). These are essential for high-performance ML models.', 'Completed', '2025-11-03 16:09:12'),
(28, 3, 8, 'Unsupervised Learning', 'Explore clustering techniques like K-Means and dimensionality reduction techniques like Principal Component Analysis (PCA) for pattern discovery and data compression.', 'Completed', '2025-11-03 16:09:12'),
(29, 3, 9, 'Neural Networks & Deep Learning', 'Learn the structure of a basic Neural Network. Understand activation functions, backpropagation, and utilize a framework like TensorFlow or PyTorch for implementation.', 'Pending', '2025-11-03 16:09:12'),
(30, 3, 10, 'MLOps & Deployment', 'Learn how to version control models (DVC) and deploy final models as a service using tools like Flask/Streamlit or cloud platforms (AWS Sagemaker, Azure ML) for real-world use.', 'Completed', '2025-11-03 16:09:12'),
(101, 4, 1, 'Cloud Fundamentals & Models', 'Master the definition, characteristics, and key benefits of cloud computing. Deeply understand the core service models: IaaS, PaaS, and SaaS, and deployment models (Public, Private, Hybrid).', 'Pending', '2025-11-03 16:15:12'),
(102, 4, 2, 'Networking & Virtualization', 'Grasp TCP/IP and basic networking (VPC/VNet, Subnets, DNS, Load Balancers). Understand Virtualization (VMs, Hypervisors) as the engine that powers the cloud.', 'Pending', '2025-11-03 16:15:12'),
(103, 4, 3, 'Core Cloud Platform Proficiency', 'Choose one major provider (AWS, Azure, or GCP). Create a free account and gain hands-on experience with foundational services: Compute (VMs/EC2), Storage (S3/Blob), and basic Databases (RDS/Azure SQL).', 'Pending', '2025-11-03 16:15:12'),
(104, 4, 4, 'Security & IAM (Identity & Access Mgmt)', 'Learn the Shared Responsibility Model. Master user and resource access control using IAM. Understand security groups, network firewalls, and basic data encryption principles.', 'Pending', '2025-11-03 16:15:12'),
(105, 4, 5, 'Linux & Shell Scripting', 'Gain proficiency in the Linux operating system and command-line interface (CLI). Learn Bash scripting or Python for automating routine infrastructure tasks and management.', 'Pending', '2025-11-03 16:15:12'),
(106, 4, 6, 'Infrastructure as Code (IaC)', 'Move beyond the console. Learn to provision and manage cloud resources using code. Master a tool like Terraform or the provider-specific tool (CloudFormation/ARM/GCP Deployment Manager).', 'Pending', '2025-11-03 16:15:12'),
(107, 4, 7, 'Containerization & Orchestration', 'Master Docker for packaging applications. Learn Kubernetes (K8s) concepts for automating the deployment, scaling, and management of containerized applications (e.g., EKS, AKS, or GKE).', 'Pending', '2025-11-03 16:15:12'),
(108, 4, 8, 'DevOps & CI/CD Pipelines', 'Understand the DevOps philosophy. Implement Continuous Integration and Continuous Deployment (CI/CD) pipelines using tools like Jenkins, GitLab CI, or provider-specific tools (CodePipeline, Azure DevOps).', 'Pending', '2025-11-03 16:15:12'),
(109, 4, 9, 'Monitoring, Logging & Observability', 'Learn to use cloud monitoring tools (CloudWatch, Azure Monitor, Stackdriver) for performance management and alerting. Master centralized logging for troubleshooting and compliance.', 'Pending', '2025-11-03 16:15:12'),
(110, 4, 10, 'Serverless & Cost Optimization', 'Explore Serverless Computing (AWS Lambda/Azure Functions/GCP Functions) to run code without managing servers. Learn best practices for Cost Optimization and resource governance.', 'Pending', '2025-11-03 16:15:12'),
(111, 5, 1, 'DBMS Fundamentals & Concepts', 'Master the definition, characteristics, and key benefits of cloud computing. Understand core service models: IaaS, PaaS, and SaaS, and deployment models (Public, Private, Hybrid).', 'Completed', '2025-11-03 16:16:10'),
(112, 5, 2, 'SQL Core: CRUD Operations', 'Master the basic SQL syntax: DML commands (SELECT, INSERT, UPDATE, DELETE). Practice filtering (WHERE), sorting (ORDER BY), and limiting results.', 'Completed', '2025-11-03 16:16:10'),
(113, 5, 3, 'Data Modeling & DDL', 'Learn database design principles. Understand Entity-Relationship Diagrams (ERDs). Master DDL commands (CREATE TABLE, ALTER TABLE, DROP TABLE) and data types.', 'Completed', '2025-11-03 16:16:10'),
(114, 5, 4, 'Relationships & Joins', 'Understand primary, foreign, and unique keys. Master combining data from multiple tables using all types of JOINs (INNER, LEFT, RIGHT, FULL).', 'Completed', '2025-11-03 16:16:10'),
(115, 5, 5, 'Advanced SQL: Aggregation & Grouping', 'Learn to use aggregate functions (COUNT, SUM, AVG, MAX, MIN). Master the GROUP BY and HAVING clauses to summarize and filter grouped data.', 'Completed', '2025-11-03 16:16:10'),
(116, 5, 6, 'Normalization & Design Principles', 'Deep dive into data organization to minimize redundancy. Understand Normalization forms (1NF, 2NF, 3NF, BCNF) and apply them to complex schemas for better data integrity.', 'Completed', '2025-11-03 16:16:10'),
(117, 5, 7, 'Transactions & ACID Properties', 'Understand database transactions (commit, rollback). Master the ACID properties (Atomicity, Consistency, Isolation, Durability) crucial for maintaining data integrity.', 'Completed', '2025-11-03 16:16:10'),
(118, 5, 8, 'Indexing & Query Optimization', 'Learn what Indexes are (e.g., B-Tree) and how they speed up read operations. Understand how to analyze Query Execution Plans to identify and fix slow queries.', 'Completed', '2025-11-03 16:16:10'),
(119, 5, 9, 'Concurrency & Backup/Recovery', 'Learn about Concurrency Control (locking, deadlocks) in multi-user systems. Master strategies for backing up data and implementing disaster recovery plans.', 'Completed', '2025-11-03 16:16:10'),
(120, 5, 10, 'NoSQL & Modern Systems', 'Explore Non-Relational databases (e.g., MongoDB, Redis). Understand the CAP Theorem (Consistency, Availability, Partition Tolerance) and decide when to use a NoSQL solution over a traditional RDBMS.', 'Completed', '2025-11-03 16:16:10'),
(141, 6, 1, 'Programming Fundamentals & OOP', 'Master object-oriented programming (OOP) principles (Encapsulation, Inheritance, Polymorphism) using a language like Java or C#. Understand data types, control flow, and clean code principles.', 'Pending', '2025-11-03 16:32:46'),
(142, 6, 2, 'Data Structures & Algorithms', 'Study fundamental Data Structures (Arrays, Linked Lists, Trees, Graphs) and core Algorithms (Sorting, Searching) essential for efficient problem-solving.', 'Pending', '2025-11-03 16:32:46'),
(143, 6, 3, 'Software Design Principles', 'Learn to apply SOLID principles, design patterns (Factory, Singleton, Observer), and software architecture models (Monolithic, Microservices).', 'Pending', '2025-11-03 16:32:46'),
(144, 6, 4, 'Version Control & Collaboration', 'Master Git and GitHub/GitLab for collaborative development, including branching strategies, pull requests, and code reviews.', 'Pending', '2025-11-03 16:32:46'),
(145, 6, 5, 'Database Integration (SQL/NoSQL)', 'Learn to interact with relational databases (SQL) and understand NoSQL alternatives (e.g., MongoDB) based on project needs.', 'Pending', '2025-11-03 16:32:46'),
(146, 6, 6, 'Testing & Quality Assurance', 'Master Unit Testing (JUnit/Pytest), Integration Testing, and Test-Driven Development (TDD) to ensure code reliability and quality.', 'Pending', '2025-11-03 16:32:46'),
(147, 6, 7, 'Web Services & APIs', 'Understand how to build and consume RESTful APIs and modern communication protocols like GraphQL.', 'Pending', '2025-11-03 16:32:46'),
(148, 6, 8, 'Cloud & Containerization', 'Learn Docker for containerizing applications and basic principles of deploying applications to cloud platforms (AWS/Azure/GCP).', 'Pending', '2025-11-03 16:32:46'),
(149, 6, 9, 'Agile & Project Management', 'Understand Agile methodologies (Scrum/Kanban) and tools used for project tracking and management (Jira, Trello).', 'Pending', '2025-11-03 16:32:46'),
(150, 6, 10, 'Security Fundamentals in Development', 'Learn secure coding practices, identify common vulnerabilities (OWASP Top 10), and secure data handling.', 'Pending', '2025-11-03 16:32:46'),
(151, 7, 1, 'Python & Scientific Libraries', 'Master Python, NumPy, Pandas, and Matplotlib/Seaborn for data manipulation, analysis, and visualization.', 'Pending', '2025-11-03 16:32:46'),
(152, 7, 2, 'Probability, Stats & Linear Algebra', 'Solidify mathematical foundations: Probability Distributions, hypothesis testing, and matrix operations (essential for neural networks).', 'Pending', '2025-11-03 16:32:46'),
(153, 7, 3, 'Data Preprocessing & Feature Engineering', 'Learn data cleaning, handling missing values, scaling, encoding, and creating new features to improve model performance.', 'Pending', '2025-11-03 16:32:46'),
(154, 7, 4, 'Classical Machine Learning', 'Implement and evaluate foundational models: Linear Regression, Logistic Regression, Decision Trees, and Support Vector Machines (SVM).', 'Pending', '2025-11-03 16:32:46'),
(155, 7, 5, 'Model Evaluation & Tuning', 'Master metrics (Precision, Recall, F1, AUC), cross-validation, and hyperparameter tuning techniques (Grid Search, Random Search).', 'Pending', '2025-11-03 16:32:46'),
(156, 7, 6, 'Introduction to Neural Networks', 'Understand the basic structure of a perceptron, forward propagation, backpropagation, and common activation functions.', 'Pending', '2025-11-03 16:32:46'),
(157, 7, 7, 'Deep Learning Frameworks', 'Gain proficiency in using Keras/TensorFlow or PyTorch for building and training complex neural network models.', 'Pending', '2025-11-03 16:32:46'),
(158, 7, 8, 'Convolutional Networks (CNNs)', 'Focus on Computer Vision tasks. Learn architecture design for image classification, object detection, and segmentation.', 'Pending', '2025-11-03 16:32:46'),
(159, 7, 9, 'Recurrent Networks (RNNs/LSTMs)', 'Focus on Sequence Data (NLP, Time Series). Understand how to process sequential data and overcome the vanishing gradient problem.', 'Pending', '2025-11-03 16:32:46'),
(160, 7, 10, 'MLOps & Deployment', 'Learn to deploy models using Flask/Streamlit, perform model versioning, and monitor model performance in production.', 'Pending', '2025-11-03 16:32:46'),
(161, 8, 1, 'Distributed Systems & Ledger Fundamentals', 'Understand the architecture of distributed systems, peer-to-peer networks, and the core concept of a distributed ledger.', 'Pending', '2025-11-03 16:32:47'),
(162, 8, 2, 'Cryptography Essentials', 'Master hashing functions (SHA-256), public-key cryptography, and digital signatures—the building blocks of blockchain security.', 'Pending', '2025-11-03 16:32:47'),
(163, 8, 3, 'Bitcoin & Blockchain Core', 'Study the history and architecture of Bitcoin, understanding UTXO, blocks, transaction validation, and the role of mining (Proof-of-Work).', 'Pending', '2025-11-03 16:32:47'),
(164, 8, 4, 'Ethereum & Smart Contracts', 'Understand the Ethereum Virtual Machine (EVM), gas fees, and the concept of decentralized applications (DApps).', 'Pending', '2025-11-03 16:32:47'),
(165, 8, 5, 'Solidity Programming', 'Learn the Solidity language to write and deploy functional Smart Contracts on test networks.', 'Pending', '2025-11-03 16:32:47'),
(166, 8, 6, 'Consensus Mechanisms', 'Deep dive into different consensus protocols: Proof-of-Stake (PoS), Delegated PoS, and practical Byzantine Fault Tolerance (pBFT).', 'Pending', '2025-11-03 16:32:47'),
(167, 8, 7, 'Token Standards & DeFi', 'Study ERC-20 (fungible tokens) and ERC-721 (NFTs). Understand the basics of Decentralized Finance (DeFi) protocols.', 'Pending', '2025-11-03 16:32:47'),
(168, 8, 8, 'Private & Consortium Blockchains', 'Explore alternative platforms like Hyperledger Fabric and R3 Corda, focusing on enterprise use cases and permissioned networks.', 'Pending', '2025-11-03 16:32:47'),
(169, 8, 9, 'Web3 Development Tools', 'Use tools like Truffle, Hardhat, and Web3.js/Ethers.js to connect frontend applications to your Smart Contracts.', 'Pending', '2025-11-03 16:32:47'),
(170, 8, 10, 'Security Auditing for Contracts', 'Learn how to identify and prevent common Smart Contract vulnerabilities (e.g., reentrancy attacks).', 'Pending', '2025-11-03 16:32:47'),
(171, 9, 1, 'OSI & TCP/IP Models', 'Master the function of each layer of the OSI model and deeply understand the TCP/IP stack, including common ports and protocols.', 'Pending', '2025-11-03 16:32:47'),
(172, 9, 2, 'IP Addressing & Subnetting', 'Gain proficiency in IPv4 and IPv6 addressing, CIDR notation, and subnetting to efficiently design network segments.', 'Pending', '2025-11-03 16:32:47'),
(173, 9, 3, 'Cabling & Topologies', 'Understand different network media (Copper, Fiber) and physical/logical network topologies.', 'Pending', '2025-11-03 16:32:47'),
(174, 9, 4, 'Routing Fundamentals', 'Configure basic static and dynamic routing protocols (e.g., OSPF, EIGRP) on routers and understand route metrics.', 'Pending', '2025-11-03 16:32:47'),
(175, 9, 5, 'Switching & VLANs', 'Configure managed switches, understand MAC addresses, ARP, and implement Virtual Local Area Networks (VLANs) for segmentation.', 'Pending', '2025-11-03 16:32:47'),
(176, 9, 6, 'Wireless Networking', 'Configure wireless access points, understand security standards (WPA2/3), and troubleshoot common Wi-Fi connectivity issues.', 'Pending', '2025-11-03 16:32:47'),
(177, 9, 7, 'Network Services (DNS/DHCP)', 'Set up and troubleshoot essential network services like Domain Name System (DNS) and Dynamic Host Configuration Protocol (DHCP).', 'Pending', '2025-11-03 16:32:47'),
(178, 9, 8, 'Network Security & Firewalls', 'Understand Access Control Lists (ACLs), configure stateful firewalls, and implement Network Address Translation (NAT).', 'Pending', '2025-11-03 16:32:47'),
(179, 9, 9, 'Monitoring & Troubleshooting', 'Use command-line tools (ping, tracert, netstat, nslookup) and network monitoring software (e.g., Nagios, Wireshark) for performance and problem analysis.', 'Pending', '2025-11-03 16:32:47'),
(180, 9, 10, 'Cloud Networking Basics', 'Understand the fundamentals of Virtual Private Clouds (VPC) and connecting on-premises networks to the cloud.', 'Pending', '2025-11-03 16:32:47'),
(181, 10, 1, 'Analysis of Algorithms (Big O)', 'Master calculating the time and space complexity of algorithms (Big O notation) to evaluate efficiency.', 'Pending', '2025-11-03 16:32:47'),
(182, 10, 2, 'Fundamental Data Structures', 'Understand and implement Arrays, Linked Lists (Singly, Doubly, Circular), Stacks (LIFO), and Queues (FIFO).', 'Pending', '2025-11-03 16:32:47'),
(183, 10, 3, 'Searching & Sorting', 'Master core algorithms like Binary Search, Bubble Sort, Merge Sort, and Quick Sort. Analyze their trade-offs in different scenarios.', 'Pending', '2025-11-03 16:32:47'),
(184, 10, 4, 'Trees', 'Study Binary Trees, Binary Search Trees (BSTs), and balanced trees (AVL/Red-Black). Practice tree traversals (Inorder, Preorder, Postorder).', 'Pending', '2025-11-03 16:32:47'),
(185, 10, 5, 'Heaps & Hash Tables', 'Implement Heaps (Max/Min) and understand how Hash Tables (Dictionaries/Maps) work, focusing on collision resolution techniques.', 'Pending', '2025-11-03 16:32:47'),
(186, 10, 6, 'Graphs Fundamentals', 'Understand graph representation (Adjacency Matrix, Adjacency List). Practice Breadth-First Search (BFS) and Depth-First Search (DFS).', 'Pending', '2025-11-03 16:32:47'),
(187, 10, 7, 'Shortest Path Algorithms', 'Implement Dijkstra\'s algorithm and the Bellman-Ford algorithm to find the shortest path in weighted graphs.', 'Pending', '2025-11-03 16:32:47'),
(188, 10, 8, 'Greedy Algorithms', 'Study algorithms that make locally optimal choices in the hope of finding a global optimum (e.g., Kruskal\'s or Prim\'s algorithm).', 'Pending', '2025-11-03 16:32:47'),
(189, 10, 9, 'Dynamic Programming (DP)', 'Master the core concepts of DP (memoization, tabulation) to solve complex problems by breaking them down into simpler overlapping subproblems.', 'Pending', '2025-11-03 16:32:47'),
(190, 10, 10, 'Practice & Interview Prep', 'Solve complex problems on platforms like LeetCode or HackerRank, focusing on combining different data structures and algorithms.', 'Pending', '2025-11-03 16:32:47'),
(191, 11, 1, 'OS Structure & Concepts', 'Define the role of the OS, kernel vs. user mode, and understand monolithic, microkernel, and hybrid OS architectures.', 'Pending', '2025-11-03 16:32:47'),
(192, 11, 2, 'Process Management', 'Understand process states, the Process Control Block (PCB), and CPU scheduling algorithms (e.g., FCFS, SJF, Round Robin).', 'Pending', '2025-11-03 16:32:47'),
(193, 11, 3, 'Threads & Concurrency', 'Master the difference between processes and threads, critical sections, race conditions, and synchronization tools (semaphores, mutexes).', 'Pending', '2025-11-03 16:32:47'),
(194, 11, 4, 'Deadlocks', 'Understand the four necessary conditions for deadlock, and methods for prevention, avoidance, detection, and recovery.', 'Pending', '2025-11-03 16:32:47'),
(195, 11, 5, 'Memory Management Basics', 'Understand logical vs. physical address space. Learn techniques like swapping, contiguous allocation, and segmentation.', 'Pending', '2025-11-03 16:32:47'),
(196, 11, 6, 'Paging & Virtual Memory', 'Master demand paging, page faults, and common page replacement algorithms (FIFO, LRU, Optimal).', 'Pending', '2025-11-03 16:32:47'),
(197, 11, 7, 'File Systems Interface', 'Understand file concept, access methods, directory structure, and file system mounting.', 'Pending', '2025-11-03 16:32:47'),
(198, 11, 8, 'I/O Systems', 'Learn about I/O hardware, polling, interrupts, Direct Memory Access (DMA), and the role of device drivers.', 'Pending', '2025-11-03 16:32:47'),
(199, 11, 9, 'Disk Scheduling', 'Study different disk scheduling algorithms (FCFS, SSTF, SCAN, C-SCAN) for optimizing disk access time.', 'Pending', '2025-11-03 16:32:47'),
(200, 11, 10, 'OS Security & Protection', 'Understand domain of protection, access matrix model, and basic security flaws in modern operating systems.', 'Pending', '2025-11-03 16:32:47'),
(201, 12, 1, 'UX Fundamentals & Research', 'Understand the difference between UI and UX. Learn user research methods (interviews, surveys) and creating user personas.', 'Pending', '2025-11-03 16:32:47'),
(202, 12, 2, 'Information Architecture (IA)', 'Master organizing and structuring content effectively. Create site maps, user flows, and wireflows.', 'Pending', '2025-11-03 16:32:47'),
(203, 12, 3, 'Wireframing & Prototyping Tools', 'Gain proficiency in industry-standard tools like Figma, Sketch, or Adobe XD for low-fidelity wireframing and interactive prototyping.', 'Pending', '2025-11-03 16:32:47'),
(204, 12, 4, 'Visual Design Principles', 'Master typography, color theory (accessibility contrast), hierarchy, spacing (Gestalt principles), and visual consistency.', 'Pending', '2025-11-03 16:32:47'),
(205, 12, 5, 'Usability Testing', 'Learn how to conduct usability tests (moderated/unmoderated), analyze results, and translate findings into design iterations.', 'Pending', '2025-11-03 16:32:47'),
(206, 12, 6, 'Interaction Design (IxD)', 'Focus on how users interact with the interface. Design effective feedback mechanisms, transitions, and micro-interactions.', 'Pending', '2025-11-03 16:32:47'),
(207, 12, 7, 'Design Systems', 'Understand the importance of Design Systems. Learn to create components, documentation, and style guides for scalable products.', 'Pending', '2025-11-03 16:32:47'),
(208, 12, 8, 'Accessibility (A11Y) & WCAG', 'Master designing interfaces that are usable by everyone. Apply WCAG standards for color contrast, screen reader compatibility, and keyboard navigation.', 'Pending', '2025-11-03 16:32:47'),
(209, 12, 9, 'Mobile & Responsive Design', 'Design for multiple platforms and screen sizes (iOS, Android, Web). Master mobile-first design philosophy.', 'Pending', '2025-11-03 16:32:47'),
(210, 12, 10, 'Portfolio Creation', 'Compile your best case studies into a clean, professional online portfolio that highlights your process and impact.', 'Pending', '2025-11-03 16:32:47'),
(211, 13, 1, 'Foundations: Networking & Linux', 'Master TCP/IP, network topologies, and the command line interface (CLI) in Kali Linux. Understand basic networking tools (ping, netstat).', 'Pending', '2025-11-03 16:32:47'),
(212, 13, 2, 'Setting up the Lab', 'Create a safe, isolated virtual environment (VMware/VirtualBox) with vulnerable machines (e.g., Metasploitable) for ethical practice.', 'Pending', '2025-11-03 16:32:47'),
(213, 13, 3, 'Reconnaissance (Footprinting)', 'Master passive and active information gathering techniques: DNS enumeration, port scanning (Nmap), and open-source intelligence (OSINT).', 'Pending', '2025-11-03 16:32:47'),
(214, 13, 4, 'Vulnerability Analysis', 'Learn to use vulnerability scanners (e.g., Nessus) and manual techniques to identify weaknesses in systems and applications.', 'Pending', '2025-11-03 16:32:47'),
(215, 13, 5, 'System Hacking & Exploitation', 'Understand password attacks, privilege escalation, and exploiting common misconfigurations using tools like Metasploit.', 'Pending', '2025-11-03 16:32:47'),
(216, 13, 6, 'Web App Hacking (OWASP Top 10)', 'Deep dive into common web flaws: SQL Injection, Cross-Site Scripting (XSS), and Broken Authentication using tools like Burp Suite.', 'Pending', '2025-11-03 16:32:47'),
(217, 13, 7, 'Wireless & Network Attacks', 'Understand Wi-Fi cracking techniques, rogue access points, and denial-of-service (DoS) attacks.', 'Pending', '2025-11-03 16:32:47'),
(218, 13, 8, 'Post Exploitation & Pivoting', 'Learn to maintain access, establish backdoors, and pivot between different internal network segments.', 'Pending', '2025-11-03 16:32:47'),
(219, 13, 9, 'Social Engineering & Physical Security', 'Understand human psychology attacks (phishing, pretexting) and basic concepts of physical security assessment.', 'Pending', '2025-11-03 16:32:47'),
(220, 13, 10, 'Reporting & Mitigation', 'Master writing professional penetration test reports detailing findings, risk severity, and clear mitigation recommendations.', 'Pending', '2025-11-03 16:32:47'),
(221, 14, 1, 'IoT Architecture & Components', 'Understand the three layers of IoT architecture (Perception, Network, Application). Identify key components: sensors, actuators, and microcontrollers.', 'Pending', '2025-11-03 16:32:47'),
(222, 14, 2, 'Embedded Systems & Arduino/Raspberry Pi', 'Gain hands-on experience programming microcontrollers (e.g., Arduino C/Python) for simple sensor reading and actuation.', 'Pending', '2025-11-03 16:32:47'),
(223, 14, 3, 'IoT Networking Protocols', 'Master low-power communication protocols (BLE, LoRaWAN) and application-layer protocols (**MQTT, CoAP**) for device-to-cloud communication.', 'Pending', '2025-11-03 16:32:47'),
(224, 14, 4, 'Cloud Integration for IoT', 'Learn to ingest massive streams of data using specialized cloud services (e.g., AWS IoT Core, Azure IoT Hub) and store data in time-series databases.', 'Pending', '2025-11-03 16:32:47'),
(225, 14, 5, 'Data Processing & Edge Computing', 'Understand how to filter and process data locally (on the device) using **Edge Computing** to reduce latency and bandwidth usage.', 'Pending', '2025-11-03 16:32:47'),
(226, 14, 6, 'Security & Trust in IoT', 'Study common IoT vulnerabilities, secure boot concepts, encryption mechanisms, and secure firmware updates.', 'Pending', '2025-11-03 16:32:47'),
(227, 14, 7, 'Data Analytics & Visualization', 'Apply data analytics to sensor data to derive insights. Use tools like Grafana or cloud dashboards for real-time visualization.', 'Pending', '2025-11-03 16:32:47'),
(228, 14, 8, 'Actuation & Feedback Loops', 'Design systems where cloud analysis triggers real-world physical responses (feedback loops) via actuators.', 'Pending', '2025-11-03 16:32:47'),
(229, 14, 9, 'Mobile Interface & User Experience', 'Develop mobile or web applications to serve as the user interface for monitoring and controlling IoT devices.', 'Pending', '2025-11-03 16:32:47'),
(230, 14, 10, 'Regulatory & Privacy Issues', 'Understand ethical considerations and regulatory frameworks (e.g., GDPR) related to collecting and using personal data from IoT devices.', 'Pending', '2025-11-03 16:32:47'),
(231, 15, 1, 'Data Science & Big Data Fundamentals', 'Understand the 5 Vs of Big Data (Volume, Velocity, Variety, Veracity, Value) and the lifecycle of data analysis.', 'Pending', '2025-11-03 16:32:47'),
(232, 15, 2, 'Hadoop Ecosystem', 'Master the core components of Hadoop: HDFS (storage) and YARN (resource management). Understand the MapReduce programming model.', 'Pending', '2025-11-03 16:32:47'),
(233, 15, 3, 'Apache Spark', 'Learn the architecture and benefits of Spark over Hadoop. Master RDDs and DataFrames for faster in-memory processing.', 'Pending', '2025-11-03 16:32:47'),
(234, 15, 4, 'Distributed Storage & NoSQL', 'Explore NoSQL databases suitable for Big Data (e.g., MongoDB, Cassandra) and their use cases compared to traditional RDBMS.', 'Pending', '2025-11-03 16:32:47'),
(235, 15, 5, 'Data Ingestion & Streaming', 'Master tools like Kafka or Flume for handling high-throughput, real-time data streams and getting data into the cluster.', 'Pending', '2025-11-03 16:32:47'),
(236, 15, 6, 'Data Warehousing Concepts', 'Understand ETL/ELT processes and concepts like schemas (Star, Snowflake) optimized for large-scale analytical querying.', 'Pending', '2025-11-03 16:32:47'),
(237, 15, 7, 'Cloud Big Data Services', 'Gain hands-on experience with cloud-native solutions (e.g., AWS EMR, Google Cloud Dataproc) for managed Big Data processing.', 'Pending', '2025-11-03 16:32:47'),
(238, 15, 8, 'Data Governance & Ethics', 'Understand data quality, lineage, and compliance requirements (e.g., privacy, anonymization) when dealing with large datasets.', 'Pending', '2025-11-03 16:32:47'),
(239, 15, 9, 'Machine Learning on Big Data', 'Apply scalable ML algorithms using Spark MLlib for clustering, classification, and regression on massive datasets.', 'Pending', '2025-11-03 16:32:47'),
(240, 15, 10, 'Visualization & Reporting', 'Use BI tools (e.g., Tableau, Power BI) or visualization libraries (e.g., D3.js) to communicate insights derived from Big Data.', 'Pending', '2025-11-03 16:32:47'),
(241, 16, 1, 'Agile Manifesto & Principles', 'Master the core values and principles of the Agile Manifesto. Understand the contrast between Agile and traditional Waterfall methodologies.', 'Pending', '2025-11-03 16:32:47'),
(242, 16, 2, 'Scrum Framework', 'Deep dive into the Scrum framework: understanding the roles (Product Owner, Scrum Master, Development Team), events (Sprint Planning, Daily Scrum), and artifacts.', 'Pending', '2025-11-03 16:32:47'),
(243, 16, 3, 'Kanban Method', 'Learn the core principles of Kanban: visualizing workflow, limiting Work In Progress (WIP), and managing flow.', 'Pending', '2025-11-03 16:32:47'),
(244, 16, 4, 'Product Vision & Roadmap', 'Learn techniques for defining a compelling product vision and creating a high-level product roadmap based on market needs.', 'Pending', '2025-11-03 16:32:47'),
(245, 16, 5, 'User Stories & Backlog Management', 'Master writing effective user stories (as a [User], I want [Goal], so that [Reason]) and prioritizing the Product Backlog.', 'Pending', '2025-11-03 16:32:47'),
(246, 16, 6, 'Estimation & Planning', 'Learn estimation techniques like Planning Poker and T-Shirt sizing. Master release planning and iteration planning.', 'Pending', '2025-11-03 16:32:47'),
(247, 16, 7, 'Metrics & Reporting', 'Understand key Agile metrics: Velocity, Burn-down charts, Cycle Time, and Lead Time for tracking project health and progress.', 'Pending', '2025-11-03 16:32:47'),
(248, 16, 8, 'Retrospectives & Continuous Improvement', 'Master facilitating effective retrospective meetings focused on continuous process improvement and adaptation.', 'Pending', '2025-11-03 16:32:47'),
(249, 16, 9, 'Lean Principles', 'Study the core concepts of Lean manufacturing and how they apply to software development (eliminating waste).', 'Pending', '2025-11-03 16:32:47'),
(250, 16, 10, 'Scaling Agile (SAFe/LeSS)', 'Understand frameworks used to apply Agile practices to very large, multi-team organizations.', 'Pending', '2025-11-03 16:32:47'),
(251, 17, 1, 'Image Processing Fundamentals', 'Understand image representation (pixels, color spaces), basic operations (filtering, convolutions), and image transformations.', 'Pending', '2025-11-03 16:32:47'),
(252, 17, 2, 'Python Libraries (OpenCV & Scikit-image)', 'Master core libraries for image manipulation, feature detection, and object tracking.', 'Pending', '2025-11-03 16:32:47'),
(253, 17, 3, 'Classical CV: Feature Extraction', 'Learn traditional techniques for finding key points and descriptors in images (e.g., SIFT, SURF, HOG) and basic geometry.', 'Pending', '2025-11-03 16:32:47'),
(254, 17, 4, 'Machine Learning Review (Clustering/Classification)', 'Review K-Nearest Neighbors, SVMs, and Decision Trees as they apply to simple image classification tasks.', 'Pending', '2025-11-03 16:32:47'),
(255, 17, 5, 'Convolutional Neural Networks (CNNs) Basics', 'Understand the core components of a CNN: convolutional layers, pooling layers, and fully connected layers.', 'Pending', '2025-11-03 16:32:47'),
(256, 17, 6, 'CNN Architectures', 'Study and implement standard, successful architectures like LeNet, AlexNet, VGG, and ResNet.', 'Pending', '2025-11-03 16:32:47'),
(257, 17, 7, 'Object Detection', 'Master techniques for identifying and localizing multiple objects in an image (e.g., R-CNN, YOLO, SSD).', 'Pending', '2025-11-03 16:32:47'),
(258, 17, 8, 'Image Segmentation', 'Learn semantic segmentation (labeling every pixel) and instance segmentation using models like U-Net.', 'Pending', '2025-11-03 16:32:47'),
(259, 17, 9, 'Transfer Learning & Fine-Tuning', 'Master using pre-trained models (e.g., from ImageNet) as a starting point to solve new, smaller problems quickly and efficiently.', 'Pending', '2025-11-03 16:32:47'),
(260, 17, 10, 'Deployment & Real-time CV', 'Learn techniques for optimizing models for speed and deploying them on edge devices or in cloud environments for real-time video stream analysis.', 'Pending', '2025-11-03 16:32:47'),
(261, 18, 1, 'Spatial Computing Fundamentals', 'Understand the concepts of virtual reality (VR), augmented reality (AR), and mixed reality (MR), and the required hardware.', 'Pending', '2025-11-03 16:32:47'),
(262, 18, 2, '3D Graphics & Game Engine Basics', 'Master the fundamentals of 3D geometry, transformations, and coordinate systems. Begin learning a relevant engine (**Unity** or Unreal Engine).', 'Pending', '2025-11-03 16:32:47'),
(263, 18, 3, 'C# Programming for Unity', 'Gain proficiency in C# scripting, which is the primary language used to manage interactions and logic within the Unity game engine.', 'Pending', '2025-11-03 16:32:47'),
(264, 18, 4, 'VR Development Principles', 'Master locomotion techniques, scene interaction, UI design for VR (spatial UI), and optimizing performance for head-mounted displays (HMDs).', 'Pending', '2025-11-03 16:32:47'),
(265, 18, 5, 'AR Tracking Techniques', 'Learn the different ways AR tracks the real world: marker-based, markerless (plane detection), and location-based tracking.', 'Pending', '2025-11-03 16:32:47'),
(266, 18, 6, 'Interaction and Input', 'Implement user input handling specific to AR/VR (controllers, hand tracking, gaze/voice interaction).', 'Pending', '2025-11-03 16:32:47'),
(267, 18, 7, 'Asset Pipeline & Optimization', 'Learn to import, optimize, and manage 3D models, textures, and audio assets to maintain high frame rates in immersive environments.', 'Pending', '2025-11-03 16:32:47'),
(268, 18, 8, 'Multiplayer & Social VR', 'Implement basic networking protocols for shared virtual spaces and understanding latency management.', 'Pending', '2025-11-03 16:32:47'),
(269, 18, 9, 'User Experience (UX) for Immersive Tech', 'Study design principles specific to AR/VR to prevent motion sickness and ensure intuitive, comfortable user experiences.', 'Pending', '2025-11-03 16:32:47'),
(270, 18, 10, 'Deployment to Devices', 'Master deploying final applications to major platforms (e.g., Oculus/Meta Quest, HoloLens, and mobile AR platforms like ARKit/ARCore).', 'Pending', '2025-11-03 16:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `school_college_company_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `study` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `school_college_company_name`, `address`, `pincode`, `study`, `dob`, `registration_date`) VALUES
(22, 'niteshkd321@gmail.com', '$2y$10$2F0LDJtSGDe6r//BHuilIuOBpK7kKDUZc/bffHKOi2V1fEZzfDVPW', 'Nitesh', 'Doddamani', '08088731856', 'BMS', 'Tamsewada, Kodibag, Karwar', '581303', 'Engineering', '2026-01-16', '2026-01-05 09:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_roadmap_progress`
--

CREATE TABLE `user_roadmap_progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `step_number` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roadmap_progress`
--

INSERT INTO `user_roadmap_progress` (`progress_id`, `user_id`, `course_id`, `step_number`, `completed_at`) VALUES
(11, 22, 1, 1, '2026-01-05 09:11:34'),
(12, 22, 1, 2, '2026-01-05 09:11:38'),
(13, 22, 1, 3, '2026-01-05 09:11:41'),
(14, 22, 1, 4, '2026-01-05 09:11:45'),
(15, 22, 1, 5, '2026-01-05 09:12:28'),
(16, 22, 1, 6, '2026-01-05 09:12:31'),
(17, 22, 1, 7, '2026-01-05 09:12:34'),
(18, 22, 1, 8, '2026-01-05 09:12:37'),
(19, 22, 1, 9, '2026-01-05 09:13:50'),
(20, 22, 1, 10, '2026-01-05 09:13:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `roadmaps`
--
ALTER TABLE `roadmaps`
  ADD PRIMARY KEY (`roadmap_id`),
  ADD UNIQUE KEY `uk_course_step` (`course_id`,`step_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_roadmap_progress`
--
ALTER TABLE `user_roadmap_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD UNIQUE KEY `user_step` (`user_id`,`course_id`,`step_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `roadmaps`
--
ALTER TABLE `roadmaps`
  MODIFY `roadmap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_roadmap_progress`
--
ALTER TABLE `user_roadmap_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `roadmaps`
--
ALTER TABLE `roadmaps`
  ADD CONSTRAINT `roadmaps_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

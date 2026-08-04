import {
    MessageSquare,
    Stethoscope,
    LinkIcon,
    Ambulance,
} from "lucide-react";
import { SectionItem } from '@/types/componentTypes'

// ======== SIDEBAR ITEMS CONTENT =======
export const sidebarItems = [
    { label: "Edit Profile", href: "/home/edit-profile" },
    {
        label: "Order with Prescription",
        href: null,
        children: [
            { label: "New Medicine", href: "/caretaker/prescribed-medicine" },
            { label: "Same Medicine", href: "/caretaker/upload-document" },
        ],
    },
    { label: "Allow Notification", href: "/home" },
    {
        label: "Manage Your Account",
        href: null,
        // href: "/home/delivery-cancellation",
        children: [
            { label: "Can I edit my profile?", href: "/home/can-i-edit" },
            { label: "Deactivate my account", href: "/home/deactivate-account" },
            { label: "I forgot my password. How do I reset it?", href: "/home/reset-password" },
        ],
    },
    { label: "Need Help?", href: "/home/need-help" },
    { label: "Term and Policy", href: "/home/term-policy" },
    { label: "About Us", href: "/home/about-us" },
];

// ========= HOME PAGE CONTENT =========
export const homeActions = [
    { id: "track-order", label: "Track Your Order", icon: Ambulance, href: "/home/track-order", desc: "Tap on “Track Your Order” to view your order details. From there, you can track your shipment in real time using your order ID IK/IGL/25-26/031/000." },
    { id: "download-doc", label: "Download Doc", icon: Stethoscope, href: "/home/all-documents", desc: "Tap the “Download Docs” button to access your documents. From here, you can download invoices, packing lists, and other approved documents." },
    { id: "payment", label: "Payment Details", icon: Stethoscope, href: "/home/payment-details", desc: "Tap on the Payment Details section to see your order payment information. From here, you can access your payment information, including status, amounts, and transaction history." },
    { id: "address", label: "Delivery Address", icon: Ambulance, href: "/caretaker/address", desc: "Tap on the Delivery Address section to add or update your shipment delivery location. From here, you can specify where you want your orders to be delivered." },
    { id: "new-order", label: "Place New Order", icon: Ambulance, href: "/caretaker/prescribed-medicine", desc: "Tap on “Place New Order” to initiate a new request. From here, you can enter the necessary details to submit your request for the new medicine request journey." },
    { id: "my-order", label: "My Orders", icon: Stethoscope, href: "/home/my-order" },
    { id: "feedback", label: "Feedback", icon: MessageSquare, href: "/home/feedback", desc: "Tap on the “Feedback” button to share your thoughts. Your valuable feedback helps us serve you better." },
    { id: "support", label: "Help & Support", icon: LinkIcon, href: "/home/help-support", desc: "Get support." },
];

export const policySections: SectionItem[] = [
    {
        title: '1. Cancellation Policy',
        description:
            'Because this process involves approvals and patient-specific medicines:',
        points: [
            'Once your request is submitted and processing has started, it cannot be cancelled.',
            'Orders are placed based on your prescription and documents',
            'In special situations, requests may be reviewed by our team'
        ]
    },
    {
        title: '2. Return Policy',
        description:
            'Since medicines are arranged specifically for each patient:',
        points: [
            'Returns are not allowed once the medicine is shipped or delivered',
            'This helps maintain safety and follows regulatory guidelines'
        ]
    },
    {
        title: '3. Shipping Policy',
        description:
            'We ensure safe delivery of medicines:',
        points: [
            'Medicines are shipped usin temperature-controlled methods when required',
            'Delivery time may vary depending on approvals and location',
            'You will receive updates and tracking details during the process'
        ]
    },
    {
        title: '4. Data Protection Policy',
        description:
            'Your data is safe with us:',
        points: [
            'Personal and medical information is securely protected',
            'Only authorized team members can access your data',
            'We follow all applicable data protection rules'
        ]
    },
    {
        title: '5. Medical Disclaimer',
        description: '',
        points: [
            'We do not provide medical advice or doctor consultations',
            'All treatment decisions must be made by your doctor',
            'Our role is to help you access medicines through the Named Patient Program.'
        ]
    },
    {
        title: '6. General Policy',
        description: '',
        points: [
            'Services depend on approvals and complete documentation',
            'Delays may happen due to external factors like authorities or logistics',
            'By using the platform, you agree to these conditions'
        ]
    },
];

// ========= NEED HELP PAGE CONTENT=============

export const helpSections: SectionItem[] = [
    {
        title: '1. How can I edit my profile?',
        description:
            'You can update your personal details from the Profile section in your account. Please ensure all information is accurate to avoid delays.',
        points: []
    },
    {
        title: '2. Is this a membership-based service?',
        description:
            'No, this is not a membership platform. You can access services and submit requests without any subscription.',
        points: []
    },
    {
        title: '3. What if I cannot find a medicine on the platform?',
        description:
            'If your required medicine is not listed, you can still submit a request manually. Our team will review it and guide you on possible access options through the Named Patient Program.',
        points: [
            'You can enter the details manually by providing:',
            '1- Medicine name',
            '2- Generic name (API)',
            '3- Dosage strength',
            '4- Quantity required',

        ],
        otherText: 'Once submitted, our team will evaluate your request and assist you further.'
    },
    {
        title: '4. Does your platform deliver medicines outside India?',
        description:
            'Yes, we can facilitate the delivery of medicines outside India through the Named Patient Program, subject to applicable regulations and documentation requirements in the destination country.',
        points: [],
    },
    {
        title: '5. Why are documents required?',
        description:
            'Documents such as prescriptions and medical records are needed to comply with regulatory guidelines and ensure safe, legal access to medicines.',
        points: [],
    },
    {
        title: '6. Does your platform support doctor consultation?',
        description:
            'No, we do not provide doctor consultations on this platform. Patients are advised to consult their treating doctor for medical advice, diagnosis, and treatment decisions.',
        points: [],
    },
    {
        title: 'Note:',
        description: 'This platform is developed and operated by Ikris Pharma Network, with its registered office at: 905, ITHUM Tower, Business Park 40, Block A, Sector 62, Noida, Uttar Pradesh – 201301, India. The platform is designed to simplify and digitize the Named Patient Program (NPP) process, ensuring seamless coordination between patients, healthcare providers, and regulatory authorities.',
        points: [
            'It provides a central ized system to manage patient requests for unapproved or special-access medicines',
            'It enables secure submission and tracking of required documentation',
            'It ensures compliance with applicable regulatory frameworks and guidelines',
        ],
        otherText: 'The platform is designed to simplify and digitize the Named Patient Program (NPP), ensuring smooth coordination between patients, healthcare providers, and regulatory authorities. It provides a centralized system to manage requests for unapproved or special-access medicines.'
    }
]

// ========== ABOUT US PAGE CONTENT ==========
export const aboutSection =
    [
        {
            number: "01",
            title: "About NPP",
            description:
                "The Named Patient Program (NPP) is a regulated pathway that enables patients to access critical medicines not commercially available in their region. It supports healthcare professionals in prescribing and facilitating access to such treatments for individual patient needs, in accordance with applicable regulatory requirements. As a leading Indian organization in the field of Named Patient Program, we are committed to enabling access to life saving therapies beyond local availability.  Our mission is to deliver a process that is compliant, reliable, and focused on patient care.",
            bg: "white",
        },
        {
            number: "02",
            title: "End-to-End Process Management",
            description:
                "We manage the complete journey from request initiation to final medicine delivery ensuring seamless coordination between patients, healthcare professionals, and regulatory authorities. ",
            bg: "gray"
        },
        {
            number: "03",
            title: "Regulatory Expertise",
            description:
                "Our team possesses in depth knowledge of Named Patient Program regulations across regions, ensuring full compliance with applicable legal requirements. We support documentation, approvals, and regulatory submissions, including coordination with the Central Drugs Standard Control Organization, to facilitate a smooth and compliant access process.",
            bg: "white"
        },
        {
            number: "04",
            title: "Secure Digital Platform",
            description:
                "We prioritize data security through advanced encryption and robust systems. All patient records and documents are securely stored, with access restricted to authorized personnel, ensuring confidentiality, integrity, and trust at every step.",
            bg: "gray"
        },
        {
            number: "05",
            title: "Real-Time Tracking",
            description:
                "Our platform provides real-time visibility into every stage of the process, enabling users to track request status, regulatory approvals, and medicine progress. This ensures transparency and helps patients and healthcare providers make timely, informed decisions.",
            bg: "white"
        },
        {
            number: "06",
            title: "About Company",
            description:
                "At Ikris Pharma Network, our work culture is built on collaboration, innovation, and a shared commitment to improving patient access to essential medicines. We believe in creating an environment where ideas are valued, teamwork is encouraged, and every individual takes ownership of their work. \n\ We foster a culture of continuous learning and adaptability, empowering our team to grow alongside evolving healthcare and technology landscapes.Transparency, accountability, and mutual respect are at the core of how we operate, ensuring that every contribution drives meaningful impact. \n Our team works with a strong sense of purpose—knowing that behind every process and every solution, there is a patient whose life can be improved through timely access to treatment.",
            bg: "gray"
        },
    ];

// HELP AND SUPPORT PAGE 
export const helpPagelinks = [
    {
        title: "How Our NPP Platform Works",
        href: "/home/help-support/how-npp-works",
    },
    {
        title: "How Can I Track My Order",
        href: "/home/help-support/how-track-order",
    },
    {
        title: "Can I Contact Delivery Person",
        href: "/home/help-support/contact-delivery-person",
    },
    {
        title: "Are there any additional charges?",
        href: "/home/help-support/additional-changes",
    },
    {
        title: "How can I order medicine if I am unable to read my prescription?",
        href: "/home/help-support/how-order-medicine",
    },
];

export const howOurNppWork = [
    {
        number: "01",
        title: "Patient Request Initiation",
        description:
            "The process begins when a patient or healthcare professional submits a request for a specific medicine through the platform. Basic details regarding the patient’s condition and required treatment are provided to initiate the case.",
        bg: "white",
    },
    {
        number: "02",
        title: "Document Submission",
        description:
            "Users are required to upload all necessary documents, including prescriptions, medical records, and consent forms. Ensuring that the documentation is complete and accurate helps avoid delays in further processing.",
        bg: "gray",
    },
    {
        number: "03",
        title: "Case Review & Validation",
        description:
            "Once the documents are submitted, our team carefully reviews and verifies the information. This step ensures that the request meets all necessary criteria and complies with regulatory requirements.",
        bg: "white",
    },
    {
        number: "04",
        title: " Regulatory Approval Process",
        description:
            "If applicable, the request is submitted to the relevant regulatory authorities for approval. The timeline for this step may vary depending on the country and governing regulations.",
        bg: "gray",
    },
    {
        number: "05",
        title: "Sourcing of Medicine",
        description:
            "After approval, the required medicine is sourced from trusted and verified global suppliers. We ensure that all products meet strict quality and compliance standards.",
        bg: "white",
    },
    {
        number: "06",
        title: "Shipping & Logistics",
        description:
            "The medicine is then shipped using secure and temperature-controlled logistics systems where required. Users are provided with tracking details to stay informed about the delivery status.",
        bg: "gray",
    },
    {
        number: "07",
        title: "Delivery & Completion",
        description:
            "Finally, the medicine is delivered to the patient or the designated healthcare provider. The process is completed with full transparency, ensuring a smooth and reliable experience.",
        bg: "white",
    },
];

// Prescribed Medicine page data
export const strengthOptions = [
    { label: "180 mg", value: "180mg" },
    { label: "200 mg", value: "200mg" },
    { label: "250 mg", value: "250mg" },
    { label: "300 mg", value: "300mg" },
    { label: "350 mg", value: "350mg" },
    { label: "1g", value: "1g" },
];

export const dosageOptions = [
    { label: "Tablet", value: "Tablet" },
    { label: "Injection", value: "Injection" },
];


export const quantityOptions = [
    { label: "1-5", value: "1-5" },
    { label: "5-10", value: "5-10" },
    { label: "10-15", value: "10-15" },
    { label: "15-20", value: "15-20" },
    { label: "20-30", value: "20-30" },
    { label: "30-40", value: "30-40" },
    { label: "40-50", value: "40-50" },
    { label: "50-60", value: "50-60" },
    { label: "60-70", value: "60-70" },
    { label: "70-80", value: "70-80" },
    { label: "80-90", value: "80-90" },
    { label: "90-100", value: "90-100" },
];
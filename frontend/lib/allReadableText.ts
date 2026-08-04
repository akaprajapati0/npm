const validPrescriptionMarkdown = `
## To ensure safe and accurate dispensing of medicines, a valid prescription must contain the following essential details:

* **Patient’s Full Name & Date**

## Clearly mentions the patient’s name and the date the prescription was issued.

* **Medication Name & Strength**

## Specifies the exact medicine prescribed along with its strength or concentration.

* **Dosage Instructions & Refills**

## Includes clear directions for use, duration of therapy, and the number of authorized refills (if applicable).

* **Doctor's Signature & License Number**

## Confirms that the prescription has been issued by a registered medical practitioner.

* **Please ensure your prescription is clear, complete, and legible to avoid delays in order processing.**
`;

const requiredPrescriptionMarkdown = `
Access to medicines through the Named Patient Program (NPP) requires a valid prescription from a licensed doctor. Since these medicines may not be approved or widely available in your country, a prescription ensures that the treatment is clinically appropriate, necessary, and used under proper medical supervision.

&nbsp;
* **Why is a prescription important?** 

&nbsp;

> **•** **Accurate Diagnosis:** Ensures the medicine suits your condition

> **•** **Correct Dosage:** Provides the right strength and duration

> **•** **Reduced Side Effects:** Minimizes risks and drug interactions

> **•** **Medical Guidance:** Allows monitoring and adjustments

> **•** **Regulatory Compliance:** Ensures responsible use
 
&nbsp;

* **What you should know**

Self-medication can be risky. Always consult a qualified healthcare professional before use.
`;

export const Prescription_CONFIG = {
    Valid_pres: {
        title: "Need Help",
        markdown: validPrescriptionMarkdown,
        fileName: "valid-prescription"
    },
    Required_pres: {
        title: "Learn Why A Prescription is Required",
        markdown: requiredPrescriptionMarkdown,
        fileName: "required-prescription"
    }
};

// KYC upload page notes
const whyKYCMarkdown = `
## KYC is essential to ensure legal access to medicines and protect patients through proper verification processes.
&nbsp;
* **Verify Patient Identity**
## Confirms the patient’s identity and prevents misuse or unauthorized access to medicines
&nbsp;
* **Enable Manual Verification**
## Allow manual checks of identity for accuracy & authenticity of medicines.
&nbsp;
* **Ensure Regulatory Compliance**
## Meets government and healthcare regulations for legal approvals.
&nbsp;
* **Protect Patient Safety**
## Ensures medicines are delivered securely to the correct individual.
&nbsp;
* **All documents must be clear and legible for successful verification.**
`;

export const KYC_CONFIG = {
    WHY_KYC: {
        title: "Why KYC is Required?",
        markdown: whyKYCMarkdown,
        fileName: "why-kyc-is-required"
    }
};

// Submit Bank reciept page notes
const whatIsSwiftMarkdown = `
# A bank receipt is a document provided after payment, confirming that the transaction has been completed. It ensures transparency and trust between both parties.
&nbsp;
* **• Verify Payment Confirmation:** Confirm that the payment has been successfully processed.
#
* **• Ensure Transaction Accuracy:** Helps check that the amount and details are correct.

* **• Protect Against Disputes** Acts as proof in case of any payment issues or discrepancies.
#
* **• Facilitate Record Keeping** Maintains a clear record for future reference and auditing.

&nbsp;

# All receipts are reviewed by our team and should be clear and easy to read for verification.
`;

// const whyNeededMarkdown = `
// # Why a SWIFT Copy is Required

// A SWIFT copy is the only universally accepted proof that an international payment has been successfully initiated. Here is why it is essential:

// ### 1. Proof of Payment
// Unlike a screenshot of your bank app, a SWIFT copy is a legal document. It proves to the recipient (the beneficiary) that the funds have actually left your bank and are on the way.

// ### 2. Tracking Delayed Funds
// If a transfer is taking longer than expected, the **UETR code** on the SWIFT copy allows both the sending and receiving banks to locate the money in the "correspondent banking" chain.

// ### 3. Error Identification
// If the money was sent to the wrong account number or the wrong bank branch, the SWIFT copy allows us to see exactly what details were entered, making it easier to fix or recall the payment.

// ### 4. Regulatory Compliance
// For high-value transfers, many banks and government agencies require a SWIFT copy to verify the source and destination of funds for tax and anti-money laundering (AML) purposes.

// > **Note:** Most banks provide the SWIFT copy 1–2 hours after the transfer is processed. If you haven't received it, you can request it from your bank's international payments desk.
// `;

export const BANK_RECEIPT_CONFIG = {
    WHAT_IS_SWIFT: {
        title: "Why Bank Receipt Is Important",
        markdown: whatIsSwiftMarkdown,
        fileName: "about-swift-mt103"
    },
    // WHY_NEEDED: {
    //     title: "Why it's Needed",
    //     markdown: whyNeededMarkdown,
    //     fileName: "why-swift-is-required"
    // }
}

// quotation text
const whyQuoteRequired = `
# Your safety and well-being are our priority. Certain medicines require a quote due to regulatory, pricing, and availability factors.
&nbsp;
# **Why requesting a quote is important:**
&nbsp;
# **Price Transparency:**  Clear, accurate pricing before confirmation.

# **Availability Check:** Confirms supply and delivery feasibility.

# **Regulatory Compliance:** Ensures all legal requirements are met.

# **Customized Needs:** Adjusts for dosage, quantity, or location.

# **Professional Review:** Verifies accuracy and suitability.
&nbsp;
# **What this means for you:**
&nbsp;
# **•** No obligation to purchase
# **•** No unexpected costs or delays.
# **•** Smooth, compliant process.
&nbsp;
# It usually takes 24–48 hours to prepare and share, and requesting a quote ensures clarity, confidence, and reliable service.
`
const whatProforma = `
# A proforma invoice is a document that shows the estimated cost and details of your medicine before you place the final order. It helps you understand the price and terms in advance.
&nbsp;
# **Process :**
&nbsp;
# 1. Share your requirement with us

# 2. Receive the proforma invoice

# 3. Check the price, quantity, and details carefully

# 4. Ask for any changes if needed before confirming
&nbsp;
# Please make sure all details are correct before approval.
&nbsp;
# It usually takes 24–48 hours to prepare and share, and requesting a quote ensures clarity, confidence, and reliable service.
`;

const whyLicenseRequired = `
# An import license ensures compliance and smooth customs clearance, helping your order move without delays or complications.
&nbsp;
# **Why requesting an import license is important:**
&nbsp;
# **•** **Legal Compliance:** Ensures your import follows government regulations and policies.

# **•** **Product Eligibility:** Confirms that the medicine can be legally imported into the destination country.

# **•** **Customs clearance:** Facilitates faster clearance with proper approvals in place.

# **•** **Avoid Penalties:** Prevents fines or confiscation due to incomplete or incorrect documentation.

# **•** **Trade Facilitation:** Supports coordination with suppliers and logistics partners.
&nbsp;
# It usually takes 24–72 hours to prepare and share, and requesting a quote ensures clarity, confidence, and reliable service.
`

export const QUOTATION_CONFIG = {
    WHY_QUOTE_REQUIRED: {
        title: "Why is a Quote Required?",
        markdown: whyQuoteRequired,
        fileName: "why-quote-required"
    },
    WHAT_PROFORMA: {
        title: "What is a Proforma Invoice?",
        markdown: whatProforma,
        fileName: "why-proforma"
    },
    WHY_LICENSE_REQUIRED: {
        title: "Why Is an Import License Required?",
        markdown: whyLicenseRequired,
        fileName: "why-license-required"
    }
}

// Submit CDEC Form notes
const CdecMarkdown = `
# Download & Complete CDEC Form

The **CDEC Form** is a mandatory declaration required by regulatory authorities to process specific international fund transfers or customs clearances.

### What is the CDEC Form?
It is a formal declaration that specifies the nature of your transaction. It ensures that the funds or goods being transferred comply with local tax laws and international trade regulations.

### Instructions to Complete:
1. **Download:** Click the download button below to save the PDF to your device.
2. **Fill Details:** Enter the transaction reference number, your tax ID (e.g., PAN/SSN), and the purpose of the remittance.
3. **Sign:** The form must be physically signed. Digital signatures are accepted only if they are cryptographically verified.
4. **Scan & Upload:** Once signed, scan the document clearly and upload it back to our portal.

### Important Notes:
* **Validity:** Ensure the date on the form matches the date of your SWIFT/MT103 request.
* **Clarity:** Ensure no text is cut off during scanning, as banks may reject blurry documents.
* **Accuracy:** Mismatched information between your CDEC form and your bank account details will lead to transaction delays.
`;

export const whyCdec = `
# The Custom Duty Exemption Certificate (CDEC) is a mandatory regulatory document required for the import of life-saving medicines. This certificate enables exemption from customs duty.
&nbsp;
# **•** **Ensure Regulatory Compliance:** Confirms that the import meets government rules and legal requirements.
&nbsp;
# **•** **Enable Customs Clearance:** Required for approval and release of medicines at customs.
&nbsp;
# **•** **Avoid Delays or Rejections:** Prevents hold-ups due to missing documents.
&nbsp;
# **•** **Support Patient Access:** Helps make essential medicines more accessible by reducing duty costs.

&nbsp;

All documents are carefully reviewed and must be clear and complete for successful approval.
`

export const CDEC_CONFIG = {
    DOWNLOAD_CDEC: {
        title: "CDEC Form Instructions",
        markdown: CdecMarkdown,
        fileName: "cdec-declaration-form"
    },
    WHY_CDEC: {
        title: "Custom Duty Certificate",
        markdown: whyCdec,
        fileName: "why-cdec-form"
    }
}

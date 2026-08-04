export default function Indication() {
    const listItems = [
        "Lysosomal Storage Disorders (LSDs)",
        "Adrenoleukodystrophy",
        "Severe Combined Immunodeficiency (SCID)",
        "Chronic Granulomatous disease",
        "Wiskot Aldrich Syndrome",
        "Osteopetrosis",
        "Fanconi Anemia",
        "Laron's Syndrome",
        "Tyrosinemia",
        "Glycogen storage disorders (GSD) I, III and IV due to poor metabolic control, multiple liver adenomas, or high risk for Hepatocellular carcinoma, or condition of substantial cirrhosis or liver dysfunction, or progressive liver failure",
        "Maple Syrup Urine Disease (MSUD)",
        "Urea cycle disorders",
        "Organic acidemias",
        "Autosomal recessive Polycystic Kidney Disease",
        "Autosomal dominant Polycystic Kidney Disease",
        "Phenylketonuria (PKU)",
        "Non-PKU hyperphenylalaninemia conditions",
        "Homocystinuria",
        "Urea Cycle Enzyme defects",
        "Glutaric Aciduria type 1 and 2",
        "Methyl Malonic Acidemia",
        "Propionic Acidemia",
        "Isovaleric Acidemia",
        "Leucine sensitive hypoglycemia",
        "Galactosemia",
        "Glucose galactose malabsorbtion",
        "Severe Food protein allergy",
        "GH deficiency",
        "Prader Willi Syndrome",
        "Turner syndrome",
        "Noonan syndrome",
        "Acidemias, mitochondrial disorders",
        "Acute Intermittent Porphyria",
        "Wilson's Disease",
        "Congenital Adrenal Hyperplasia",
        "Neonatal onset Multisystem inflammatory Disease (NoMID)",
        "Gaucher Disease Type I and III",
        "Hurler Syndrome [Mucopolysaccharisosis (MPS) Type I]",
        "Hunter syndrome (MPS II)",
        "Pompe Disease",
        "Fabry Disease",
        "MPS IVA",
        "MPS VI",
        "Cystic Fibrosis",
        "Duchenne Muscular Dystrophy",
        "Spinal Muscular Atrophy",
        "Wolman Disease",
        "Hypophosphatasia",
        "Neuronal ceroid lipofuschinosis",
        "Hypophosphatic Rickets",
        "Atypical Hemolytic Uremic Syndrome."
    ];

    return (
        <div style={{ padding: '40px', fontFamily: 'serif', lineHeight: '1.4', color: '#333' }}>
            <h3 style={{ textDecoration: 'underline', marginBottom: '20px', fontSize: '1.1rem' }}>
                List 22 (See S. No. 403 of TABLE I)
            </h3>
            <ol style={{ paddingLeft: '25px', listStyleType: 'decimal' }}>
                {listItems.map((item, index) => (
                    <li key={index} style={{ marginBottom: '4px', paddingLeft: '10px' }}>
                        {item}
                    </li>
                ))}
            </ol>
        </div>
    );
}
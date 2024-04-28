<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Medicine::create([
            'name' => 'Napa 500 MG Tablet',
            'slug' => 'napa-500mg',
            'pro_cat_id' => 1,
            'pro_sub_cat_id' => 1,
            'generic_id' => 1,
            'company_id' => 1,
            'strength_id' => 1,
            'unit' => json_encode(["1","2",'3']),
            'price' => 1.08,
            'regular_price' => 1.08,
            'description' => "Indications of Napa 500 mg
            Napa 500 mg is indicated for fever, common cold and influenza, headache, toothache, earache, bodyache, myalgia, neuralgia, dysmenorrhoea, sprains, colic pain, back pain, post-operative pain, postpartum pain, inflammatory pain and post vaccination pain in children. It is also indicated for rheumatic & osteoarthritic pain and stiffness of joints.
            
            Theropeutic Class
            Non opioid analgesics
            
            Pharmacology
            Napa 500 mg has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 500 mg (Acetaminophen) is thought to act primarily in the CNS, increasing the pain threshold by inhibiting both isoforms of cyclooxygenase, COX-1, COX-2, and COX-3 enzymes involved in prostaglandin (PG) synthesis. Napa 500 mg is a para aminophenol derivative, has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 500 mg is one of the most widely used, safest and fast acting analgesic. It is well tolerated and free from various side effects of aspirin.
            
            Dosage & Administration of Napa 500 mg
            Tablet:
            Adult: 1-2 tablets every 4 to 6 hours up to a maximum of 4 gm (8 tablets) daily.
            Children (6-12 years): ½ to 1 tablet 3 to 4 times daily. For long term treatment it is wise not to exceed the dose beyond 2.6 gm/day.
            Extended Release Tablet:
            Adults & Children over 12 years: Two tablets, swallowed whole, every 6 to 8 hours (maximum of 6 tablets in any 24 hours).The tablet must not be crushed.
            Syrup/Suspension:
            Children under 3 months: 10 mg/kg body weight (reduce to 5 mg/kg if jaundiced) 3 to 4 times daily.
            3 months to below 1 year: ½ to 1 teaspoonful 3 to 4 times daily.
            1-5 years: 1 -2 teaspoonful 3 to 4 times daily.
            6-12 years: 2-A teaspoonful 3 to 4 times daily.
            Adults: 4-8 teaspoonful 3 to 4 times daily.
            Suppository:
            Children 3-12 months: 60-120 mg,4 times daily.
            Children 1-5 years: 125-250 mg 4 times daily.
            Children 6-12 years: 250-500 mg 4 times daily.
            Adults & children over 12 years: 0.5-1 gm 4 times daily.
            Paediatric Drop:
            Children Upto 3 months: 0.5 ml (40 mg)
            4 to 11 months: 1.0 ml (80 mg)
            7 to 2 years: 1.5 ml (120 mg). Do not exceed more than 5 dose daily for a maximum of 5 days.
            Napa 500 mg tablet with actizorb technology: It dissolves up to five times faster than standard Napa 500 mg tablets. It is a fast acting and safe analgesic with marked antipyretic property. It is specially suitable for patients who, for any reason, can not tolerate aspirin or other analgesics.
            Adults and children (aged 12 years and over): Take 1 to 2 Tablets every four to six hours as needed. Do not take more than 8 caplets in 24 hours.
            Children (7 to 11 years): Take ½-1 Tablet every four to six hours as needed. Do not take more than 4 caplets in 24 hours. Not recommended in children under 7 years.
            Interaction of Napa 500 mg
            Patients who have taken barbiturates, tricyclic antidepressants and alcohol may show diminished ability to metabolise large doses of Napa 500 mg. Alcohol can increase the hepatotoxicity of Napa 500 mg overdosage. Chronic ingestion of anticonvulsants or oral steroid contraceptives induce liver enzymes and may prevent attainment of therapeutic Napa 500 mg levels by increasing first-pass metabolism or clearance.
            
            Contraindications
            It is contraindicated in known hypersensitivity to Napa 500 mg.
            
            Side Effects of Napa 500 mg
            Side effects of Napa 500 mg are usually mild, though haematological reactions including thrombocytopenia, leucopenia, pancytopenia, neutropenia, and agranulocytosis have been reported. Pancreatitis, skin rashes, and other allergic reactions occur occasionally.
            
            Pregnancy & Lactation
            Pregnancy category B according to USFDA. This drug should be used during pregnancy only if clearly needed
            
            Precautions & Warnings
            Napa 500 mg should be given with caution to patients with impaired kidney or liver function. Napa 500 mg should be given with care to patients taking other drugs that affect the liver.
            
            Overdose Effects of Napa 500 mg
            Symptoms of Napa 500 mg overdose in the first 24 hours are pallor, nausea, vomiting, anorexia and abdominal pain. Liver damage may become apparent 12-48 hours after ingestion. Abnormalities of glucose metabolism and metabolic acidosis may occur.
            
            Storage Conditions
            Keep in a dry place away from light and heat. Keep out of the reach of children.
            
            Drug Classes
            Non opioid analgesics
            
            Mode Of Action
            Napa 500 mg has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 500 mg (Acetaminophen) is thought to act primarily in the CNS, increasing the pain threshold by inhibiting both isoforms of cyclooxygenase, COX-1, COX-2, and COX-3 enzymes involved in prostaglandin (PG) synthesis. Napa 500 mg is a para aminophenol derivative, has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 500 mg is one of the most widely used, safest and fast acting analgesic. It is well tolerated and free from various side effects of aspirin.
            
            Pregnancy
            Pregnancy category B according to USFDA. This drug should be used during pregnancy only if clearly needed.  Napa 500 mg is excreted in breast milk. Maternal ingestion of Napa 500 mg in normal therapeutic doses does not appear to present a risk to the nursing infant.",
            'prescription_required' => NULL,
            'max_quantity' => NULL,
            'kyc_required' => NULL,
            'status' => 1,
            'is_best_selling' => 1,
        ]);
        
    }
}

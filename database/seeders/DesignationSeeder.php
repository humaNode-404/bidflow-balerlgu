<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Complete list of designations
        $designations = [
            // Financial/Accounting Related
            ['title' => 'Accountant', 'category' => 'Financial', 'suffix' => 'I'],
            ['title' => 'Accountant', 'category' => 'Financial', 'suffix' => 'II'],
            ['title' => 'Accountant', 'category' => 'Financial', 'suffix' => 'III'],
            ['title' => 'Accountant', 'category' => 'Financial', 'suffix' => 'IV'],
            ['title' => 'Accountant', 'category' => 'Financial', 'suffix' => 'V'],
            ['title' => 'Accounting Clerk', 'category' => 'Financial', 'suffix' => 'I'],
            ['title' => 'Accounting Clerk', 'category' => 'Financial', 'suffix' => 'II'],

            // Administrative Related
            ['title' => 'Administrative Aide', 'category' => 'Administrative', 'suffix' => 'I'],
            ['title' => 'Administrative Aide', 'category' => 'Administrative', 'suffix' => 'II'],
            ['title' => 'Administrative Aide', 'category' => 'Administrative', 'suffix' => 'III'],
            ['title' => 'Administrative Aide', 'category' => 'Administrative', 'suffix' => 'IV'],
            ['title' => 'Administrative Aide', 'category' => 'Administrative', 'suffix' => 'V'],
            ['title' => 'Administrative Aide', 'category' => 'Administrative', 'suffix' => 'VI'],
            ['title' => 'Administrative Aide', 'category' => 'Administrative', 'suffix' => 'VII'],
            ['title' => 'Administrative Aide', 'category' => 'Administrative', 'suffix' => 'VIII'],
            ['title' => 'Administrative Assistant', 'category' => 'Administrative', 'suffix' => 'I'],
            ['title' => 'Administrative Assistant', 'category' => 'Administrative', 'suffix' => 'II'],
            ['title' => 'Administrative Assistant', 'category' => 'Administrative', 'suffix' => 'III'],
            ['title' => 'Administrative Assistant', 'category' => 'Administrative', 'suffix' => 'IV'],
            ['title' => 'Administrative Officer', 'category' => 'Administrative', 'suffix' => 'I'],
            ['title' => 'Administrative Officer', 'category' => 'Administrative', 'suffix' => 'II'],
            ['title' => 'Administrative Officer', 'category' => 'Administrative', 'suffix' => 'III'],
            ['title' => 'Administrative Officer', 'category' => 'Administrative', 'suffix' => 'IV'],
            ['title' => 'Administrative Officer', 'category' => 'Administrative', 'suffix' => 'V'],

            // Agricultural & Technical Related
            ['title' => 'Agricultural Biosystems Engineer', 'category' => 'Agriculture', 'suffix' => 'I'],
            ['title' => 'Agricultural Biosystems Engineer', 'category' => 'Agriculture', 'suffix' => 'II'],
            ['title' => 'Agriculturist', 'category' => 'Agriculture', 'suffix' => 'I'],
            ['title' => 'Agriculturist', 'category' => 'Agriculture', 'suffix' => 'II'],
            ['title' => 'Agricultural Technologist', 'category' => 'Agriculture', 'suffix' => null],

            // Assessment & Planning Related
            ['title' => 'Assessor', 'category' => 'Assessment', 'suffix' => 'I'],
            ['title' => 'Assessor', 'category' => 'Assessment', 'suffix' => 'II'],
            ['title' => 'Planning Officer', 'category' => 'Planning', 'suffix' => null],

            // Bac Related
            ['title' => 'BAC Chairperson', 'category' => 'Governance', 'suffix' => null],
            ['title' => 'BAC Member', 'category' => 'Governance', 'suffix' => null],
            ['title' => 'BAC Secretariat', 'category' => 'Governance', 'suffix' => null],

            // Health Related
            ['title' => 'Health Officer', 'category' => 'Health', 'suffix' => null],
            ['title' => 'Medical Officer', 'category' => 'Health', 'suffix' => 'I'],
            ['title' => 'Medical Officer', 'category' => 'Health', 'suffix' => 'II'],
            ['title' => 'Nurse', 'category' => 'Health', 'suffix' => 'I'],
            ['title' => 'Nurse', 'category' => 'Health', 'suffix' => 'II'],
            ['title' => 'Midwife', 'category' => 'Health', 'suffix' => 'I'],
            ['title' => 'Midwife', 'category' => 'Health', 'suffix' => 'II'],
            ['title' => 'Rural Health Physician', 'category' => 'Health', 'suffix' => null],

            // Municipal Staff Related
            ['title' => 'Municipal Accountant', 'category' => 'Financial', 'suffix' => null],
            ['title' => 'Municipal Administrator', 'category' => 'Administrative', 'suffix' => null],
            ['title' => 'Municipal Agriculturist', 'category' => 'Agriculture', 'suffix' => null],
            ['title' => 'Municipal Assessor', 'category' => 'Assessment', 'suffix' => null],
            ['title' => 'Municipal Budget Officer', 'category' => 'Financial', 'suffix' => null],
            ['title' => 'Municipal Engineer', 'category' => 'Engineering', 'suffix' => null],
            ['title' => 'Municipal Health Officer', 'category' => 'Health', 'suffix' => null],
            ['title' => 'Municipal Information Systems Analyst', 'category' => 'Technical', 'suffix' => null],
            ['title' => 'Municipal Legal Officer', 'category' => 'Legal', 'suffix' => null],
            ['title' => 'Municipal Planning and Development Coordinator', 'category' => 'Planning', 'suffix' => null],
            ['title' => 'Municipal Social Welfare and Development Officer', 'category' => 'Social Services', 'suffix' => null],
            ['title' => 'Municipal Treasurer', 'category' => 'Financial', 'suffix' => null],

            // Technical & Other Specialized Roles
            ['title' => 'Engineer', 'category' => 'Engineering', 'suffix' => 'I'],
            ['title' => 'Engineer', 'category' => 'Engineering', 'suffix' => 'II'],
            ['title' => 'Sanitary Engineer', 'category' => 'Engineering', 'suffix' => null],

            // Governance, Legal, and Administrative
            ['title' => 'Liaison Officer', 'category' => 'Administrative', 'suffix' => null],
            ['title' => 'Legal Officer', 'category' => 'Legal', 'suffix' => null],
            ['title' => 'Officer-in-Charge', 'category' => 'Administrative', 'suffix' => null],
            ['title' => 'Property Custodian', 'category' => 'Administrative', 'suffix' => null],

            // Social Services
            ['title' => 'Social Welfare Officer', 'category' => 'Social Services', 'suffix' => 'I'],
            ['title' => 'Social Welfare Officer', 'category' => 'Social Services', 'suffix' => 'II'],

            // Disaster Risk & Safety
            ['title' => 'Disaster Risk Reduction and Management Officer', 'category' => 'Safety', 'suffix' => 'I'],
            ['title' => 'Disaster Risk Reduction and Management Officer', 'category' => 'Safety', 'suffix' => 'II'],
            ['title' => 'Peace and Order Officer', 'category' => 'Safety', 'suffix' => null],
            ['title' => 'Public Safety Officer', 'category' => 'Safety', 'suffix' => null],

            // Others
            ['title' => 'Job Order Worker', 'category' => 'Miscellaneous', 'suffix' => null],
            ['title' => 'Utility Worker', 'category' => 'Miscellaneous', 'suffix' => null],
            ['title' => 'Zoning Officer', 'category' => 'Planning', 'suffix' => null],
            ['title' => 'Training Officer', 'category' => 'Administrative', 'suffix' => null],
        ];

        // Insert the designations into the database
        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}

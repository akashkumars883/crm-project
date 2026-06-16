<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\Customer;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\ProjectStatus;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceType;
use App\Models\InvoiceStatus;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Designation;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Roles ───────────────────────────────────────────
        foreach (['super-admin','admin','manager','supervisor','accounts','hr','employee','client','vendor'] as $rn) {
            Role::firstOrCreate(['name' => $rn, 'display_name' => ucwords(str_replace('-', ' ', $rn))]);
        }

        // ── Lookups ─────────────────────────────────────────
        $ls1 = LeadSource::firstOrCreate(['name' => 'Website']);
        $ls2 = LeadSource::firstOrCreate(['name' => 'Facebook']);
        $ls3 = LeadSource::firstOrCreate(['name' => 'Google Ads']);
        $ls4 = LeadSource::firstOrCreate(['name' => 'Referral']);
        LeadStatus::firstOrCreate(['name' => 'New']);
        LeadStatus::firstOrCreate(['name' => 'Qualified']);
        LeadStatus::firstOrCreate(['name' => 'Converted']);

        $invType = InvoiceType::firstOrCreate(['name' => 'Tax Invoice']);
        $invStatus1 = InvoiceStatus::firstOrCreate(['name' => 'Pending']);
        $invStatus2 = InvoiceStatus::firstOrCreate(['name' => 'Paid']);

        $pt1 = ProjectType::firstOrCreate(['name' => 'False Ceiling']);
        $pt2 = ProjectType::firstOrCreate(['name' => 'Painting']);
        $ps1 = ProjectStatus::firstOrCreate(['name' => 'In Progress']);
        $ps2 = ProjectStatus::firstOrCreate(['name' => 'Completed']);

        PaymentMethod::firstOrCreate(['name' => 'NEFT']);
        PaymentMethod::firstOrCreate(['name' => 'Cheque']);
        $payS1 = PaymentStatus::firstOrCreate(['name' => 'Received']);
        $payS2 = PaymentStatus::firstOrCreate(['name' => 'Pending']);

        TicketCategory::firstOrCreate(['name' => 'General Inquiry']);
        TicketCategory::firstOrCreate(['name' => 'Billing Issue']);
        TicketCategory::firstOrCreate(['name' => 'Service Request']);

        $empType = EmployeeType::firstOrCreate(['name' => 'Full Time']);
        $desig1 = Designation::firstOrCreate(['name' => 'Project Manager']);
        $desig2 = Designation::firstOrCreate(['name' => 'Site Engineer']);
        $desig3 = Designation::firstOrCreate(['name' => 'Painter']);
        Department::firstOrCreate(['name' => 'Operations']);

        // ── Users ───────────────────────────────────────────
        $superadmin = User::firstOrCreate(['email' => 'superadmin@homeglazer.com'], ['name' => 'Super Admin', 'password' => Hash::make('password123')]);
        $this->attachRole($superadmin, 'super-admin');

        $admin = User::firstOrCreate(['email' => 'admin@homeglazer.com'], ['name' => 'Admin User', 'password' => Hash::make('password123')]);
        $this->attachRole($admin, 'admin');

        $mgr = User::firstOrCreate(['email' => 'manager@homeglazer.com'], ['name' => 'Rajesh Kumar', 'password' => Hash::make('password123')]);
        $this->attachRole($mgr, 'manager');

        // Employees are created through admin UI which handles all required fields
        $empUser = User::firstOrCreate(['email' => 'employee@homeglazer.com'], ['name' => 'Test Employee', 'password' => Hash::make('password123')]);
        $this->attachRole($empUser, 'employee');

        // ── Customers ───────────────────────────────────────
        $customers = $this->seedCustomer('harekrishna@vrindavan.org', 'Hare Krishna Moment - Vrindavan', '9876543210',
            'Vrindavan Chandrodaya Mandir, Bhaktivedanta Swami Marg, MATHURA, UTTAR PRADESH, INDIA, PIN Code:281121',
            'Vrindavan', 'Uttar Pradesh', '281121', '09AAATH7073G1ZJ', $ls1->id);

        $sharma = $this->seedCustomer('sharma.residence@example.com', 'Sharma Residence', '9988776655',
            'A-12, Saket, New Delhi', 'New Delhi', 'Delhi', '110017', null, $ls2->id);

        $kumar = $this->seedCustomer('kumar.family@example.com', 'Kumar Family', '9123456789',
            'B-25, Vasant Kunj, New Delhi', 'New Delhi', 'Delhi', '110070', null, $ls3->id);

        // ── Projects ────────────────────────────────────────
        Project::firstOrCreate(
            ['customer_id' => $customers['customer']->id, 'name' => 'Hare Krishna - False Ceiling & Painting'],
            ['project_type_id' => $pt1->id, 'project_status_id' => $ps1->id, 'assigned_to' => $mgr->id,
             'start_date' => now()->subMonths(2), 'end_date' => now()->addMonths(1), 'total_area' => 15000,
             'estimated_cost' => 1500000, 'final_cost' => 1303133, 'progress_percent' => 65,
             'description' => 'Complete false ceiling, drywall partition, POP cornice, PVC moulding and painting work for Hare Krishna Moment temple complex at Vrindavan.']
        );

        Project::firstOrCreate(
            ['customer_id' => $sharma['customer']->id, 'name' => 'Sharma Residence - Painting'],
            ['project_type_id' => $pt2->id, 'project_status_id' => $ps1->id, 'assigned_to' => $mgr->id,
             'start_date' => now()->subMonths(1), 'end_date' => now()->addDays(20), 'total_area' => 2500,
             'estimated_cost' => 350000, 'final_cost' => 350000, 'progress_percent' => 80,
             'description' => 'Complete interior painting including putty work and texture finishes.']
        );

        // ── Tax Invoice (matches PDF) ───────────────────────
        $invoice = Invoice::firstOrCreate(
            ['lead_id' => $customers['lead']->id, 'invoice_number' => 'HG/25-26/022'],
            ['invoice_date' => '2025-12-10', 'invoice_type_id' => $invType->id, 'invoice_status_id' => $invStatus1->id,
             'value' => 1303133, 'bill_to_name' => 'Hare Krishna Moment - Vrindavan', 'bill_to_gstin' => '09AAATH7073G1ZJ',
             'bill_to_address' => 'Vrindavan Chandrodaya Mandir, Bhaktivedanta Swami Marg, MATHURA, UTTAR PRADESH, INDIA',
             'bill_to_city' => 'Vrindavan', 'bill_to_state' => 'Uttar Pradesh', 'bill_to_pincode' => '281121',
             'work_address' => 'Vrindavan Chandrodaya Mandir, Bhaktivedanta Swami Marg, MATHURA, UTTAR PRADESH, INDIA, PIN Code:281121',
             'subtotal' => 1104350, 'discount' => 0, 'igst_percent' => 18, 'igst_amount' => 198783,
             'shipping' => 0, 'balance_due' => 1303133, 'remarks' => 'As per terms mentioned in work order',
             'bank_name' => 'IDFC Bank', 'bank_account_name' => 'Home Glazer Solutions Private Limited',
             'bank_account_no' => '10183062134', 'bank_branch' => 'Udyog Vihar, Gurgaon', 'bank_ifsc' => 'IDFB0021014']
        );

        $items = [
            [1, 'False Ceiling Suspender', 764, 100, 76400],
            [2, 'False Ceiling Perameter', 202.5, 60, 12150],
            [3, 'POP Cornice', 396.16, 150, 59424],
            [4, 'PVC Moulding', 404.32, 50, 20216],
            [5, 'False Ceiling Dismentaling', 1013.56, 25, 25339],
            [6, 'False Ceiling (With jointing compound)', 2270.78, 135, 306555],
            [7, 'False Ceiling (Without jointing compound)', 2163.08, 110, 237939],
            [8, 'False Ceiling (Frame)', 1585.39, 90, 142685],
            [9, 'False Ceiling Suspender (Wastage)', 92, 150, 13800],
            [10, '2 Coat wall putty', 5069, 11, 55759],
            [11, 'Drywall Partition', 267.96, 150, 40194],
            [12, 'Ceiling and wall POP repair', 'L', 0, 20000],
            [13, 'Material Handover', 'L', 0, 93889],
        ];
        foreach ($items as [$sr, $desc, $qty, $price, $total]) {
            $qtyType = $qty === 'L' ? 'lumpsum' : 'number';
            InvoiceItem::firstOrCreate(
                ['invoice_id' => $invoice->id, 'sr_no' => $sr],
                ['description' => $desc, 'hsn_sac' => '995472', 'quantity_type' => $qtyType,
                 'quantity' => $qtyType === 'lumpsum' ? null : (float)$qty, 'price' => (float)$price, 'total' => (float)$total]
            );
        }

        // Second invoice (Paid)
        $inv2 = Invoice::firstOrCreate(
            ['lead_id' => $sharma['lead']->id, 'invoice_number' => 'HG/25-26/023'],
            ['invoice_date' => '2025-12-15', 'invoice_type_id' => $invType->id, 'invoice_status_id' => $invStatus2->id,
             'value' => 425000, 'bill_to_name' => 'Sharma Residence', 'bill_to_address' => 'A-12, Saket',
             'bill_to_city' => 'New Delhi', 'bill_to_state' => 'Delhi', 'bill_to_pincode' => '110017',
             'subtotal' => 360169, 'discount' => 0, 'igst_percent' => 18, 'igst_amount' => 64831,
             'shipping' => 0, 'balance_due' => 425000, 'remarks' => 'Payment received - thank you!']
        );
        InvoiceItem::firstOrCreate(['invoice_id' => $inv2->id, 'sr_no' => 1],
            ['description' => 'Interior Painting - 2 Coat Putty + Primer + 2 Coat Paint', 'hsn_sac' => '995472',
             'quantity_type' => 'number', 'quantity' => 2500, 'price' => 120, 'total' => 300000]);
        InvoiceItem::firstOrCreate(['invoice_id' => $inv2->id, 'sr_no' => 2],
            ['description' => 'Wood Painting (Doors & Windows)', 'hsn_sac' => '995472',
             'quantity_type' => 'number', 'quantity' => 300, 'price' => 100, 'total' => 30000]);
        InvoiceItem::firstOrCreate(['invoice_id' => $inv2->id, 'sr_no' => 3],
            ['description' => 'Enamel Paint Finish', 'hsn_sac' => '995472',
             'quantity_type' => 'number', 'quantity' => 150, 'price' => 200, 'total' => 30169]);

        // ── Sample Payments ────────────────────────────────
        Payment::firstOrCreate(['reference' => 'PMT-2025-001'], [
            'customer_id' => $customers['customer']->id, 'amount' => 500000, 'payment_method_id' => 1,
            'payment_status_id' => $payS1->id, 'project_id' => 1, 'notes' => 'Advance payment'
        ]);
        Payment::firstOrCreate(['reference' => 'PMT-2025-002'], [
            'customer_id' => $sharma['customer']->id, 'amount' => 425000, 'payment_method_id' => 1,
            'payment_status_id' => $payS1->id, 'project_id' => 2, 'notes' => 'Full payment received'
        ]);
        Payment::firstOrCreate(['reference' => 'PMT-2025-003'], [
            'customer_id' => $customers['customer']->id, 'amount' => 200000, 'payment_method_id' => 2,
            'payment_status_id' => $payS2->id, 'project_id' => 1, 'notes' => 'Cheque deposited - pending clearance'
        ]);

        // ── Sample Tickets ─────────────────────────────────
        Ticket::firstOrCreate(['client_id' => $customers['user']->id, 'subject' => 'Need update on remaining work'],
            ['message' => 'Please update on the remaining false ceiling work on 3rd floor.', 'ticket_category_id' => 3, 'status' => 'Pending', 'priority' => 'medium']);
        Ticket::firstOrCreate(['client_id' => $sharma['user']->id, 'subject' => 'Painting color confirmation'],
            ['message' => 'Want to change color in master bedroom from off-white to ivory.', 'ticket_category_id' => 1, 'status' => 'Pending', 'priority' => 'low']);
    }

    private function attachRole($user, $roleName) {
        $role = Role::where('name', $roleName)->first();
        if ($role && !$user->hasRole($roleName)) {
            $user->roles()->attach($role);
        }
    }

    private function seedCustomer($email, $name, $phone, $address, $city, $state, $zip, $gstin, $sourceId) {
        $lead = Lead::firstOrCreate(['email' => $email], [
            'lead_source_id' => $sourceId, 'lead_status_id' => 3, 'name' => $name, 'phone' => $phone,
            'address' => $address, 'city' => $city, 'state' => $state, 'zip' => $zip
        ]);
        $user = User::firstOrCreate(['email' => $email], ['name' => $name, 'password' => Hash::make('customer123')]);
        $this->attachRole($user, 'client');
        $customer = Customer::firstOrCreate(['lead_id' => $lead->id], [
            'user_id' => $user->id, 'phone' => $phone, 'address' => $address,
            'city' => $city, 'state' => $state, 'zip' => $zip,
            'company_name' => $name, 'gstin' => $gstin
        ]);
        return ['lead' => $lead, 'user' => $user, 'customer' => $customer];
    }
}

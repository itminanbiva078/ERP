<?php

namespace Database\Seeders;

use App\Models\CompanyCategory;
use App\Models\CompanyResource;
use App\Models\FormInput;
use App\Models\Navigation;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\UserRole;
use App\Models\RoleAccess;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        Navigation::truncate();
        $parent_menu = array(

            (object) array(
                'label' => 'Customer Manage',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => (object) array(
                   

                    (object) array(
                        'label' => 'Customer Group',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'customer_groups',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Customer Group', 'route' => 'salesSetup.customerGroup.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Customer Group', 'route' => 'salesSetup.customerGroup.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Group', 'route' => 'salesSetup.customerGroup.dataProcessingCustomerGroup', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Customer Group', 'route' => 'salesSetup.customerGroup.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Customer Group', 'route' => 'salesSetup.customerGroup.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Group Store', 'route' => 'salesSetup.customerGroup.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Group Update', 'route' => 'salesSetup.customerGroup.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Customer Media',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'customer_media',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Customer Media', 'route' => 'salesSetup.customerMedia.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Customer Media', 'route' => 'salesSetup.customerMedia.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Media', 'route' => 'salesSetup.customerMedia.dataProcessingCustomerMedia', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Customer Media', 'route' => 'salesSetup.customerMedia.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Customer Media', 'route' => 'salesSetup.customerMedia.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Media Store', 'route' => 'salesSetup.customerMedia.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Media Update', 'route' => 'salesSetup.customerMedia.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Customer',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'customers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Customer', 'route' => 'salesSetup.customer.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Customer', 'route' => 'salesSetup.customer.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer', 'route' => 'salesSetup.customer.dataProcessingCustomer', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Customer', 'route' => 'salesSetup.customer.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Customer', 'route' => 'salesSetup.customer.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Store', 'route' => 'salesSetup.customer.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Update', 'route' => 'salesSetup.customer.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                )
            ),






            (object) array(
                'label' => 'Sales Transaction',
                'route' => null,
                'icon' => 'fa fa-balance-scale',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Sales Quatation',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sales_quatations',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Sales Quatation', 'route' => 'salesTransaction.salesQuatation.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Sales Quatation', 'route' => 'salesTransaction.salesQuatation.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Quatation', 'route' => 'salesTransaction.salesQuatation.dataProcessingSalesQuatation', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Sales Quatation', 'route' => 'salesTransaction.salesQuatation.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Sales Quatation', 'route' => 'salesTransaction.salesQuatation.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Sales Quatation', 'route' => 'salesTransaction.salesQuatation.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Quatation Store', 'route' => 'salesTransaction.salesQuatation.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Quatation Update', 'route' => 'salesTransaction.salesQuatation.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Quatation Approved', 'route' => 'salesTransaction.salesQuatation.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    
                    (object) array(
                        'label' => 'Sales Quatation Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sales_quatation_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'salesTransaction.salesQuatation.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                   (object) array(
                        'label' => 'Sales',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sales',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Sales', 'route' => 'salesTransaction.sales.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Sales', 'route' => 'salesTransaction.sales.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales', 'route' => 'salesTransaction.sales.dataProcessingSales', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Sales', 'route' => 'salesTransaction.sales.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Sales', 'route' => 'salesTransaction.sales.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Sales', 'route' => 'salesTransaction.sales.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Store', 'route' => 'salesTransaction.sales.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Update', 'route' => 'salesTransaction.sales.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Approval', 'route' => 'salesTransaction.sales.accountApproved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    
                    (object) array(
                        'label' => 'Sales Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sales_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'salesTransaction.sales.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    
                   (object) array(
                        'label' => 'Sales Loan',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sales_lons',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Sales', 'route' => 'salesTransaction.salesLoan.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Sales', 'route' => 'salesTransaction.salesLoan.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales', 'route' => 'salesTransaction.salesLoan.dataProcessingSalesLoan', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Sales', 'route' => 'salesTransaction.salesLoan.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Sales', 'route' => 'salesTransaction.salesLoan.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Sales', 'route' => 'salesTransaction.salesLoan.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Store', 'route' => 'salesTransaction.salesLoan.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Update', 'route' => 'salesTransaction.salesLoan.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    
                    (object) array(
                        'label' => 'Sales Loan Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sales_lon_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'salesTransaction.salesLoan.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    
                    (object) array(
                        'label' => 'Delivery Challan',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'delivery_challans',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Delivery Challan', 'route' => 'salesTransaction.deliveryChallan.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Delivery Challan', 'route' => 'salesTransaction.deliveryChallan.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Delivery Challan', 'route' => 'salesTransaction.deliveryChallan.dataProcessingDeliveryChallan', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Delivery Challan', 'route' => 'salesTransaction.deliveryChallan.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Delivery Challan', 'route' => 'salesTransaction.deliveryChallan.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Delivery Challan', 'route' => 'salesTransaction.deliveryChallan.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Delivery Challan Store', 'route' => 'salesTransaction.deliveryChallan.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Delivery Challan Update', 'route' => 'salesTransaction.deliveryChallan.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Delivery Challan Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'delivery_challan_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'salesTransaction.deliveryChallan.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Pending Cheque',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sale_pending_cheques',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Cheque', 'route' => 'salesTransaction.sales.pendingCheque.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Pending Cheque', 'route' => 'salesTransaction.sales.pendingCheque.dataProcessingSalePendingCheque', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Add New Payment', 'route' => 'salesTransaction.sales.pendingCheque.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Pending Cheque', 'route' => 'salesTransaction.sales.pendingCheque.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Pending Cheque', 'route' => 'salesTransaction.sales.pendingCheque.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Pending Cheque Approved', 'route' => 'salesTransaction.sales.pendingCheque.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                           
                        )
                    ),
                    (object) array(
                        'label' => 'Sale Payment',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sale_payments',
                        'childMenu' => (object) array(

                        (object) array('label' => 'All Payment', 'route' => 'salesTransaction.salePayment.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                        (object) array('label' => 'Payment', 'route' => 'salesTransaction.salePayment.dataProcessingSalePayment', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        (object) array('label' => 'Add New Payment', 'route' => 'salesTransaction.salePayment.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        (object) array('label' => 'Sale Payment Store', 'route' => 'salesTransaction.salePayment.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        (object) array('label' => 'Show Payment', 'route' => 'salesTransaction.salePayment.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                     )
                    ),


                  
                )
            ),




            (object) array(
                'label' => 'Sales Report',
                'route' => null,
                'icon' => 'fa fa-random',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Customer Ledger',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => null,
                        'childMenu' => (object) array(
                            (object) array('label' => 'Customer Ledger', 'route' => 'salesReport.salesLedger', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                                )
                    ),
                   
                    (object) array(
                        'label' => 'Sales Report',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => null,
                        'childMenu' => (object) array(
                            (object) array('label' => 'Sales Report', 'route' => 'salesReport.saleStockLedger', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                        )
                    ),
                   

                )
            ),


            
            (object) array(
                'label' => 'Service Setup',
                'route' => null,
                'icon' => 'fa fa-random',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Service Category',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'service_categories',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Service Category', 'route' => 'serviceSetup.serviceCategory.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Service Category', 'route' => 'serviceSetup.serviceCategory.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Category', 'route' => 'serviceSetup.serviceCategory.dataProcessingServiceCategory', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Service Category', 'route' => 'serviceSetup.serviceCategory.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Service Category', 'route' => 'serviceSetup.serviceCategory.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Category Store', 'route' => 'serviceSetup.serviceCategory.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Category Update', 'route' => 'serviceSetup.serviceCategory.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Service Name',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'services',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Service Group', 'route' => 'serviceSetup.service.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Service Group', 'route' => 'serviceSetup.service.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Group', 'route' => 'serviceSetup.service.dataProcessingService', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Service Group', 'route' => 'serviceSetup.service.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Service Group', 'route' => 'serviceSetup.service.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Group Store', 'route' => 'serviceSetup.service.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Group Update', 'route' => 'serviceSetup.service.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                )
            ),
            (object) array(
                'label' => 'Service Transaction',
                'route' => null,
                'icon' => 'fa fa-random',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Service Quatation',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'service_quatations',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Service Quatation', 'route' => 'serviceTransaction.serviceQuatation.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Service Quatation', 'route' => 'serviceTransaction.serviceQuatation.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Quatation', 'route' => 'serviceTransaction.serviceQuatation.dataProcessingServiceQuatation', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Service Quatation', 'route' => 'serviceTransaction.serviceQuatation.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Service Quatation', 'route' => 'serviceTransaction.serviceQuatation.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Service Quatation', 'route' => 'serviceTransaction.serviceQuatation.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Quatation Store', 'route' => 'serviceTransaction.serviceQuatation.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Quatation Update', 'route' => 'serviceTransaction.serviceQuatation.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Quatation Approval', 'route' => 'serviceTransaction.serviceQuatation.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                        )
                    ),

                    (object) array(
                        'label' => 'Service Quatation Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'service_quatation_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'serviceTransaction.serviceQuatation.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Service Invoice',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'service_invoices',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Service Invoice', 'route' => 'serviceTransaction.serviceInvoice.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Service Invoice', 'route' => 'serviceTransaction.serviceInvoice.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Invoice', 'route' => 'serviceTransaction.serviceInvoice.dataProcessingServiceInvoice', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Service Invoice', 'route' => 'serviceTransaction.serviceInvoice.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Service Invoice', 'route' => 'serviceTransaction.serviceInvoice.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Service Invoice', 'route' => 'serviceTransaction.serviceInvoice.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Invoice Store', 'route' => 'serviceTransaction.serviceInvoice.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Invoice Update', 'route' => 'serviceTransaction.serviceInvoice.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Service Invoice Approval', 'route' => 'serviceTransaction.serviceInvoice.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                        )
                    ),
                    (object) array(
                        'label' => 'Service Invoice Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'service_invoice_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'serviceTransaction.serviceInvoice.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                   
 
                )
            ),

            (object) array(
                'label' => 'Product Manage',
                'route' => null,
                'icon' => 'fa fa-cubes',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Product Category',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'categories',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Category', 'route' => 'inventorySetup.category.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Category', 'route' => 'inventorySetup.category.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Category', 'route' => 'inventorySetup.category.dataProcessingCategory', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Category', 'route' => 'inventorySetup.category.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Category', 'route' => 'inventorySetup.category.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Category Store', 'route' => 'inventorySetup.category.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Category Update', 'route' => 'inventorySetup.category.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    

                    (object) array(
                        'label' => 'Product',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'products',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Product', 'route' => 'inventorySetup.product.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Product', 'route' => 'inventorySetup.product.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Product', 'route' => 'inventorySetup.product.dataProcessingProduct', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Product', 'route' => 'inventorySetup.product.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Product', 'route' => 'inventorySetup.product.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Product Store', 'route' => 'inventorySetup.product.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Product Update', 'route' => 'inventorySetup.product.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Product Details',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'product_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Product Details', 'route' => 'inventorySetup.productDetails.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Floor',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'table' => 'floors',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Floor', 'route' => 'inventorySetup.floor.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Floor', 'route' => 'inventorySetup.floor.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Floor', 'route' => 'inventorySetup.floor.dataProcessingFloor', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Floor', 'route' => 'inventorySetup.floor.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Floor', 'route' => 'inventorySetup.floor.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Floor Store', 'route' => 'inventorySetup.floor.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Floor Update', 'route' => 'inventorySetup.floor.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    // (object) array(
                    //     'label' => 'Product Attributes',
                    //     'route' => null,
                    //     'icon' => 'fa fa-home',
                    //     'parent_id' => null,
                    //     'table' => 'product_attributes',
                    //     'childMenu' => (object) array(
                    //         (object) array('label' => 'All Product Attributes', 'route' => '', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                    //     )
                    // ),
                    (object) array(
                        'label' => 'Unit',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'product_units',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All  Unit', 'route' => 'inventorySetup.unit.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New  Unit', 'route' => 'inventorySetup.unit.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Unit', 'route' => 'inventorySetup.unit.dataProcessingUnit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit  Unit', 'route' => 'inventorySetup.unit.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy  Unit', 'route' => 'inventorySetup.unit.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Unit Store', 'route' => 'inventorySetup.unit.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Unit Update', 'route' => 'inventorySetup.unit.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Brand',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'brands',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Brand', 'route' => 'inventorySetup.brand.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Brand', 'route' => 'inventorySetup.brand.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Brand', 'route' => 'inventorySetup.brand.dataProcessingBrand', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Brand', 'route' => 'inventorySetup.brand.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Brand', 'route' => 'inventorySetup.brand.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Brand Store', 'route' => 'inventorySetup.brand.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Brand Update', 'route' => 'inventorySetup.brand.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    
                    (object) array(
                        'label' => 'Warranty',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'warranties',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Warranty', 'route' => 'inventorySetup.warranty.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Warranty', 'route' => 'inventorySetup.warranty.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Warranty', 'route' => 'inventorySetup.warranty.dataProcessingWarranty', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Warranty', 'route' => 'inventorySetup.warranty.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Warranty', 'route' => 'inventorySetup.warranty.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Warranty Store', 'route' => 'inventorySetup.warranty.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Warranty Update', 'route' => 'inventorySetup.warranty.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Product Review',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'reviews',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Product Review', 'route' => 'inventorySetup.productReview.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Destroy Product Review', 'route' => 'inventorySetup.productReview.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Product Review', 'route' => 'inventorySetup.productReview.dataProcessingProductReview', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                            
                        )
                    ),


                )
            ),

            (object) array(
                'label' => 'Supplier Manage',
                'route' => null,
                'icon' => 'fa fa-user-secret',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Supplier Group',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'supplier_groups',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Supplier Group', 'route' => 'inventorySetup.supplierGroup.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Supplier Group', 'route' => 'inventorySetup.supplierGroup.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Supplier Group', 'route' => 'inventorySetup.supplierGroup.dataProcessingSupplierGroup', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Supplier Group', 'route' => 'inventorySetup.supplierGroup.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Supplier Group', 'route' => 'inventorySetup.supplierGroup.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Supplier Group Store', 'route' => 'inventorySetup.supplierGroup.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Supplier Group Update', 'route' => 'inventorySetup.supplierGroup.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Supplier',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'suppliers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Supplier', 'route' => 'inventorySetup.supplier.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Supplier', 'route' => 'inventorySetup.supplier.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Supplier', 'route' => 'inventorySetup.supplier.dataProcessingSupplier', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Supplier', 'route' => 'inventorySetup.supplier.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Supplier', 'route' => 'inventorySetup.supplier.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Supplier Store', 'route' => 'inventorySetup.supplier.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Supplier Update', 'route' => 'inventorySetup.supplier.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                   
                )
            ),


            (object) array(
                'label' => 'Purchases Manage',
                'route' => null,
                'icon' => 'fas fa-shopping-cart',
                'parent_id' => 0,
                'submenu' => (object) array(
                    
                    (object) array(
                        'label' => 'Purchases Requisition',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchase_requisitions',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Purchases Requisition', 'route' => 'inventoryTransaction.purchasesRequisition.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Purchases Requisition', 'route' => 'inventoryTransaction.purchasesRequisition.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Requisition', 'route' => 'inventoryTransaction.purchasesRequisition.dataProcessingpurchasesRequisition', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Purchases Requisition', 'route' => 'inventoryTransaction.purchasesRequisition.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Purchases Requisition', 'route' => 'inventoryTransaction.purchasesRequisition.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Purchases Requisition', 'route' => 'inventoryTransaction.purchasesRequisition.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Requisition Store', 'route' => 'inventoryTransaction.purchasesRequisition.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Requisition Update', 'route' => 'inventoryTransaction.purchasesRequisition.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Requisition Approval', 'route' => 'inventoryTransaction.purchasesRequisition.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                        )
                    ),
                    (object) array(
                        'label' => 'Purchases Requisition Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchase_requisition_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'inventoryTransaction.purchasesRequisition.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Purchases Orders',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases_orders',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Purchases Orders', 'route' => 'inventoryTransaction.purchasesOrder.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Purchases Orders', 'route' => 'inventoryTransaction.purchasesOrder.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Orders', 'route' => 'inventoryTransaction.purchasesOrder.dataProcessingPurchasesOrder', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Purchases Orders', 'route' => 'inventoryTransaction.purchasesOrder.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Purchases Orders', 'route' => 'inventoryTransaction.purchasesOrder.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Purchases Orders', 'route' => 'inventoryTransaction.purchasesOrder.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Orders Store', 'route' => 'inventoryTransaction.purchasesOrder.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Orders Update', 'route' => 'inventoryTransaction.purchasesOrder.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Orders Approval', 'route' => 'inventoryTransaction.purchasesOrder.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                        )
                    ),
                    (object) array(
                        'label' => 'Purchases Orders Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases_order_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'inventoryTransaction.purchasesOrder.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Purchases',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Purchases', 'route' => 'inventoryTransaction.purchases.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Purchases', 'route' => 'inventoryTransaction.purchases.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases', 'route' => 'inventoryTransaction.purchases.dataProcessingPurchases', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Purchases', 'route' => 'inventoryTransaction.purchases.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Purchases', 'route' => 'inventoryTransaction.purchases.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Purchases', 'route' => 'inventoryTransaction.purchases.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Store', 'route' => 'inventoryTransaction.purchases.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Update', 'route' => 'inventoryTransaction.purchases.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Approval', 'route' => 'inventoryTransaction.purchases.accountApproved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Purchases Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'inventoryTransaction.purchases.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Purchases MRR',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases_mrrs',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Purchases MRR', 'route' => 'inventoryTransaction.purchasesMRR.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Purchases MRR', 'route' => 'inventoryTransaction.purchasesMRR.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases MRR', 'route' => 'inventoryTransaction.purchasesMRR.dataProcessingpurchasesMRR', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Purchases MRR', 'route' => 'inventoryTransaction.purchasesMRR.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Purchases MRR', 'route' => 'inventoryTransaction.purchasesMRR.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Purchases MRR', 'route' => 'inventoryTransaction.purchasesMRR.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases MRR Store', 'route' => 'inventoryTransaction.purchasesMRR.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases MRR Update', 'route' => 'inventoryTransaction.purchasesMRR.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),


                    (object) array(
                        'label' => 'Purchases MRR Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases_mrr_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'inventoryTransaction.purchasesMRR.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    
                    

                    (object) array(
                        'label' => 'Inventory Adjustment',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'inventory_adjustments',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Inventory Adjustment', 'route' => 'inventoryTransaction.inventoryAdjustment.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Inventory Adjustment', 'route' => 'inventoryTransaction.inventoryAdjustment.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Inventory Adjustment', 'route' => 'inventoryTransaction.inventoryAdjustment.dataProcessingInventoryAdjustment', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Inventory Adjustment', 'route' => 'inventoryTransaction.inventoryAdjustment.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Inventory Adjustment', 'route' => 'inventoryTransaction.inventoryAdjustment.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Inventory Adjustment', 'route' => 'inventoryTransaction.inventoryAdjustment.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Inventory Adjustment Store', 'route' => 'inventoryTransaction.inventoryAdjustment.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Inventory Adjustment Update', 'route' => 'inventoryTransaction.inventoryAdjustment.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Inventory Adjustment Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'inventory_adjustment_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'inventoryTransaction.inventoryAdjustment.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Pending Cheque',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases_pending_cheques',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Cheque', 'route' => 'inventoryTransaction.purchases.pendingCheque.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Pending Cheque', 'route' => 'inventoryTransaction.purchases.pendingCheque.dataProcessingPurchasesPendingCheque', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Add New Payment', 'route' => 'inventoryTransaction.purchases.pendingCheque.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Pending Cheque', 'route' => 'inventoryTransaction.purchases.pendingCheque.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Pending Cheque', 'route' => 'inventoryTransaction.purchases.pendingCheque.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Pending Cheque Approval', 'route' => 'inventoryTransaction.purchases.pendingCheque.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                           
                        )
                    ),
                    (object) array(
                        'label' => 'Purchases Payment',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases_payments',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Payment', 'route' => 'inventoryTransaction.purchasesPayment.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Payment', 'route' => 'inventoryTransaction.purchasesPayment.dataProcessingPurchasesPayment', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Add New Payment', 'route' => 'inventoryTransaction.purchasesPayment.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Payment Store', 'route' => 'inventoryTransaction.purchasesPayment.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Payment', 'route' => 'inventoryTransaction.purchasesPayment.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                           
                        )
                    ),
                   
                )
            ),
            (object) array(
                'label' => 'Purchases Report',
                'route' => null,
                'icon' => 'fa fa-random',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Supplier Ledger',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'service_invoices',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Supplier Ledger', 'route' => 'purchasesReport.supplierLedger', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                                )
                    ),
                    (object) array(
                        'label' => 'Stock Ledger',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'service_invoices',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Stock Ledger', 'route' => 'purchasesReport.stockLedger', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                                )
                    ),

                    // (object) array(
                    //     'label' => 'Purchases Report',
                    //     'route' => null,
                    //     'icon' => 'fa fa-th-large',
                    //     'parent_id' => null,
                    //     'table' => 'service_invoice_details',
                    //     'childMenu' => (object) array(
                    //         (object) array('label' => 'Purchases Report', 'route' => 'purchasesReport.dateAndSupplierWise', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                    //     )
                    // ),

                    // (object) array(
                    //     'label' => 'Product Ledger',
                    //     'route' => null,
                    //     'icon' => 'fa fa-th-large',
                    //     'parent_id' => null,
                    //     'table' => 'service_quatations',
                    //     'childMenu' => (object) array(
                    //         (object) array('label' => 'Product Ledger', 'route' => 'purchasesReport.productLedger', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                    //               )
                    // ),

                    // (object) array(
                    //     'label' => 'Transfer Report',
                    //     'route' => null,
                    //     'icon' => 'fa fa-th-large',
                    //     'parent_id' => null,
                    //     'table' => 'service_quatation_details',
                    //     'childMenu' => (object) array(
                    //         (object) array('label' => 'Transfer Report', 'route' => 'purchasesReport.transferReport', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                    //     )
                    // ),
 
                )
            ),
            (object) array(
                'label' => 'Transfer',
                'route' => null,
                'icon' => 'fas fa-exchange-alt',
                'parent_id' => 0,
                'submenu' => (object) array(

                    (object) array(
                        'label' => 'Transfer',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'transpfers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Transfer', 'route' => 'inventoryTransaction.transfer.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Transfer', 'route' => 'inventoryTransaction.transfer.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Transfer', 'route' => 'inventoryTransaction.transfer.dataProcessingTransfer', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Transfer', 'route' => 'inventoryTransaction.transfer.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Transfer', 'route' => 'inventoryTransaction.transfer.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Transfer', 'route' => 'inventoryTransaction.transfer.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Transfer Store', 'route' => 'inventoryTransaction.transfer.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Transfer Update', 'route' => 'inventoryTransaction.transfer.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Transfer Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'transfer_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'inventoryTransaction.transfer.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                 )
            ),

            (object) array(
                'label' => 'Task Setup',
                'route' => null,
                'icon' => 'fa fa-tasks',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Task Category',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'task_categories',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Task Category', 'route' => 'taskSetup.taskCategory.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Task Category', 'route' => 'taskSetup.taskCategory.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Task Category', 'route' => 'taskSetup.taskCategory.dataProcessingTaskCategory', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Task Category', 'route' => 'taskSetup.taskCategory.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Task Category', 'route' => 'taskSetup.taskCategory.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Task Category Store', 'route' => 'taskSetup.taskCategory.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Task Category Update', 'route' => 'taskSetup.taskCategory.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Task Status',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'task_statuses',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Task Status', 'route' => 'taskSetup.taskStatus.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Task Status', 'route' => 'taskSetup.taskStatus.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Task Status', 'route' => 'taskSetup.taskStatus.dataProcessingTaskStatus', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Task Status', 'route' => 'taskSetup.taskStatus.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Task Status', 'route' => 'taskSetup.taskStatus.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Task Status Store', 'route' => 'taskSetup.taskStatus.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Task Status Update', 'route' => 'taskSetup.taskStatus.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                )
            ),

            (object) array(
                'label' => 'Task Transaction',
                'route' => null,
                'icon' => 'fa fa-tasks',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Task Create',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'task_creates',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Task Create', 'route' => 'taskTransaction.taskCreate.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Task Create', 'route' => 'taskTransaction.taskCreate.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Task Create', 'route' => 'taskTransaction.taskCreate.dataProcessingTaskCreate', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Task Create', 'route' => 'taskTransaction.taskCreate.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Task Create', 'route' => 'taskTransaction.taskCreate.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Task Create Store', 'route' => 'taskTransaction.taskCreate.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Task Create Update', 'route' => 'taskTransaction.taskCreate.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
               )
            ),

            (object) array(
                'label' => 'Accounts Setup',
                'route' => null,
                'icon' => 'fas fa-chart-bar',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Account',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'chart_of_accounts',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Account', 'route' => 'accountSetup.chartOfAccount.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Account', 'route' => 'accountSetup.chartOfAccount.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Account', 'route' => 'accountSetup.chartOfAccount.dataProcessingChartOfAccount', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Account', 'route' => 'accountSetup.chartOfAccount.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Account', 'route' => 'accountSetup.chartOfAccount.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Account Store', 'route' => 'accountSetup.chartOfAccount.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Account Update', 'route' => 'accountSetup.chartOfAccount.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Bank',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'banks',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Bank', 'route' => 'accountSetup.bank.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Bank', 'route' => 'accountSetup.bank.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Bank', 'route' => 'accountSetup.bank.dataProcessingBank', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Bank', 'route' => 'accountSetup.bank.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Bank', 'route' => 'accountSetup.bank.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Bank Store', 'route' => 'accountSetup.bank.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Bank Update', 'route' => 'accountSetup.bank.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Account Type',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'account_types',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Account Type', 'route' => 'accountSetup.accountType.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Account Type', 'route' => 'accountSetup.accountType.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Account Type', 'route' => 'accountSetup.accountType.dataProcessingAccountType', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Account Type', 'route' => 'accountSetup.accountType.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Account Type', 'route' => 'accountSetup.accountType.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Account Type Store', 'route' => 'accountSetup.accountType.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Account Type Update', 'route' => 'accountSetup.accountType.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ), 

                )
            ),

            (object) array(
                'label' => 'Accounts Transaction',
                'route' => null,
                'icon' => 'fas fa-chart-bar',
                'parent_id' => 0,
                'submenu' => (object) array(

                    (object) array(
                        'label' => 'Payment Voucher',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'payment_vouchers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Payment Voucher', 'route' => 'accountTransaction.paymentVoucher.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Payment Voucher', 'route' => 'accountTransaction.paymentVoucher.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Payment Voucher', 'route' => 'accountTransaction.paymentVoucher.dataProcessingPaymentVoucher', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Payment Voucher', 'route' => 'accountTransaction.paymentVoucher.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Payment Voucher', 'route' => 'accountTransaction.paymentVoucher.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Payment Voucher', 'route' => 'accountTransaction.paymentVoucher.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Payment Voucher Store', 'route' => 'accountTransaction.paymentVoucher.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Payment Voucher Update', 'route' => 'accountTransaction.paymentVoucher.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Payment Voucher Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'payment_voucher_ledgers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Payment Details', 'route' => 'accountTransaction.paymentVoucher.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Receive Voucher',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'receive_vouchers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Receive Voucher', 'route' => 'accountTransaction.receiveVoucher.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Receive Voucher', 'route' => 'accountTransaction.receiveVoucher.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Receive Voucher', 'route' => 'accountTransaction.receiveVoucher.dataProcessingReceiveVoucher', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Receive Voucher', 'route' => 'accountTransaction.receiveVoucher.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Receive Voucher', 'route' => 'accountTransaction.receiveVoucher.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Receive Voucher', 'route' => 'accountTransaction.receiveVoucher.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Receive Voucher Store', 'route' => 'accountTransaction.receiveVoucher.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Receive Voucher Update', 'route' => 'accountTransaction.receiveVoucher.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),


                    (object) array(
                        'label' => 'Receive Voucher Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'receive_voucher_ledgers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Receive Details', 'route' => 'accountTransaction.receiveVoucher.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Journal Voucher',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'journal_vouchers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Journal Voucher', 'route' => 'accountTransaction.journalVoucher.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Journal Voucher', 'route' => 'accountTransaction.journalVoucher.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Journal Voucher', 'route' => 'accountTransaction.journalVoucher.dataProcessingJournalVoucher', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Journal Voucher', 'route' => 'accountTransaction.journalVoucher.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Journal Voucher', 'route' => 'accountTransaction.journalVoucher.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Journal Voucher', 'route' => 'accountTransaction.journalVoucher.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Journal Voucher Store', 'route' => 'accountTransaction.journalVoucher.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Journal Voucher Update', 'route' => 'accountTransaction.journalVoucher.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Journal Voucher Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'journal_voucher_ledgers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Journal Details', 'route' => 'accountTransaction.journalVoucher.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Contra Voucher',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'contra_vouchers',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Contra Voucher', 'route' => 'accountTransaction.contralVoucher.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Contra Voucher', 'route' => 'accountTransaction.contralVoucher.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Contra Voucher', 'route' => 'accountTransaction.contralVoucher.dataProcessingContralVoucher', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Contra Voucher', 'route' => 'accountTransaction.contralVoucher.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Contra Voucher', 'route' => 'accountTransaction.contralVoucher.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Contra Voucher', 'route' => 'accountTransaction.contralVoucher.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Contra Voucher Store', 'route' => 'accountTransaction.contralVoucher.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Contra Voucher Update', 'route' => 'accountTransaction.contralVoucher.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Contra Voucher Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'contra_voucher_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Contra Details', 'route' => 'accountTransaction.contralVoucher.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                )
            ),
           
            (object) array(
                'label' => 'Accounts Reports',
                'route' => null,
                'icon' => 'fas fa-chart-bar',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'General Ledger',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => null,
                        'childMenu' => (object) array(
                            (object) array('label' => 'General Ledger', 'route' => 'accountReport.generalLedger', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                          
                        )
                    ),
                    (object) array(
                        'label' => 'Income Statement',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => null,
                        'childMenu' => (object) array(
                            (object) array('label' => 'Income Statement', 'route' => 'accountReport.incomeStatement', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                          
                        )
                    ),
                    (object) array(
                        'label' => 'Balance Sheet',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => null,
                        'childMenu' => (object) array(
                            (object) array('label' => 'Balance Sheet', 'route' => 'accountReport.balanceSheet', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                          
                        )
                    ),
                    (object) array(
                        'label' => 'Trial Balance',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => null,
                        'childMenu' => (object) array(
                            (object) array('label' => 'Trial Balance', 'route' => 'accountReport.trialBalance', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                          
                        )
                    ),


                    (object) array(
                        'label' => 'Journal Check',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => null,
                        'childMenu' => (object) array(
                            (object) array('label' => 'Journal Cheque', 'route' => 'accountReport.journalCheck', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                          
                        )
                    ),
                    
                )
            ),



            (object) array(
                'label' => 'Return',
                'route' => null,
                'icon' => 'fa fa-retweet',
                'parent_id' => 0,
                'submenu' => (object) array(

                   (object) array(
                        'label' => 'Sale Return',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sale_returns',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Sale Return', 'route' => 'salesTransaction.salesReturn.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Sale Return', 'route' => 'salesTransaction.salesReturn.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Return', 'route' => 'salesTransaction.salesReturn.dataProcessingSalesReturn', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Sales Return', 'route' => 'salesTransaction.salesReturn.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Sales Return', 'route' => 'salesTransaction.salesReturn.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Sales Return', 'route' => 'salesTransaction.salesReturn.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Store Return', 'route' => 'salesTransaction.salesReturn.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Update Return', 'route' => 'salesTransaction.salesReturn.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Return Approved', 'route' => 'salesTransaction.salesReturn.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Sales Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sale_return_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'salesTransaction.salesReturn.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                   (object) array(
                        'label' => 'Sale Loan Return',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sales_loan_returns',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Sale Loan Return', 'route' => 'salesTransaction.salesLoanReturn.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Sale Loan Return', 'route' => 'salesTransaction.salesLoanReturn.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Loan Return', 'route' => 'salesTransaction.salesLoanReturn.dataProcessingSalesLoanReturn', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Sales Loan Return', 'route' => 'salesTransaction.salesLoanReturn.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Sales Loan Return', 'route' => 'salesTransaction.salesLoanReturn.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Sales Loan Return', 'route' => 'salesTransaction.salesLoanReturn.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Loan Store Return', 'route' => 'salesTransaction.salesLoanReturn.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sales Loan Update Return', 'route' => 'salesTransaction.salesLoanReturn.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Sales Loan Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sales_loan_return_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'salesTransaction.salesLoanReturn.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    
                    (object) array(
                        'label' => 'Purchases Return',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases_returns',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Purchases Return', 'route' => 'inventoryTransaction.purchasesReturn.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Purchases Return', 'route' => 'inventoryTransaction.purchasesReturn.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Return', 'route' => 'inventoryTransaction.purchasesReturn.dataProcessingPurchasesReturn', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Purchases Return', 'route' => 'inventoryTransaction.purchasesReturn.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Purchases Return', 'route' => 'inventoryTransaction.purchasesReturn.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Purchases Return', 'route' => 'inventoryTransaction.purchasesReturn.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Return Store', 'route' => 'inventoryTransaction.purchasesReturn.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Return Update', 'route' => 'inventoryTransaction.purchasesReturn.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Purchases Return Approval', 'route' => 'inventoryTransaction.purchasesReturn.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Purchases Return Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'purchases_return_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'inventoryTransaction.purchasesReturn.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                
                )
            ),
            (object) array(
                'label' => 'Booking',
                'route' => null,
                'icon' => 'fas fa-bed',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Booking',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'bookings',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Booking', 'route' => 'booking.booking.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Booking', 'route' => 'booking.booking.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Booking', 'route' => 'booking.booking.dataProcessingBooking', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Booking', 'route' => 'booking.booking.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Booking', 'route' => 'booking.booking.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Booking', 'route' => 'booking.booking.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Booking Store', 'route' => 'booking.booking.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Booking Update', 'route' => 'booking.booking.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Booking Status', 'route' => 'booking.booking.approved', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                   
                
                )
            ),
           

            (object) array(
                'label' => 'Pos',
                'route' => null,
                'icon' => 'fa fa-calculator',
                'parent_id' => 0,
                'submenu' => (object) array(

                    (object) array(
                        'label' => 'Pos',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'pos',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Pos', 'route' => 'pos.pos.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Pos', 'route' => 'pos.pos.dataProcessingPos', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Add New Pos', 'route' => 'pos.pos.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Pos', 'route' => 'pos.transaction.pos.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Pos', 'route' => 'pos.pos.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Pos', 'route' => 'pos.pos.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )

                    ),  
                    
                )
            ),

            (object) array(
                'label' => 'Others',
                'route' => null,
                'icon' => 'fa fa-asterisk',
                'parent_id' => 0,
                'submenu' => (object) array(
  
                    (object) array(
                        'label' => 'Email',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'mailboxes',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add Sent Mail', 'route' => 'mailbox.sent.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Sent Mail List', 'route' => 'mailbox.sent.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Sent Mail Store', 'route' => 'mailbox.sent.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Sent Mail', 'route' => 'mailbox.sent.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                     ),

                     (object) array(
                        'label' => 'SMS',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'sms',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add  SMS', 'route' => 'sms.sms.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'SMS List', 'route' => 'sms.sms.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'SMS Store', 'route' => 'sms.sms.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show SMS', 'route' => 'sms.sms.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),                              
                        )
                     ), 
                   )
            ),

           

            (object) array(
                'label' => 'Appearance',
                'route' => null,
                'icon' => 'fas fa-eye',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Editor',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => null,
                        'childMenu' => (object) array(
                            (object) array('label' => 'Editor', 'route' => 'theme.appearance.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                          
                        )
                    ),
                    (object) array(
                        'label' => 'Theme Option',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => null,
                        'childMenu' => (object) array(
                            //(object) array('label' => 'Editor', 'route' => 'theme.appearance.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Theme Option', 'route' => 'theme.appearance.theme.option', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                           
                        )
                    ),
                   
                    (object) array(
                        'label' => 'Media Gallery',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'media',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Media Gallery', 'route' => 'theme.appearance.media', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                           
                        )
                     ), 
                 )     
            ),


            (object) array(
                'label' => 'Website',
                'route' => null,
                'icon' => 'fas fa-eye',
                'parent_id' => 0,
                'submenu' => (object) array(
                   
                    (object) array(
                        'label' => 'Contact',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'contacts',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Contact List', 'route' => 'theme.appearance.website.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Contact', 'route' => 'theme.appearance.website.dataProcessingContact', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Contact Store', 'route' => 'theme.appearance.website.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Contact Destroy', 'route' => 'theme.appearance.website.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                        )
                     ), 
                    (object) array(
                        'label' => 'Subscribe',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'subscribes',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Subscribe List', 'route' => 'theme.appearance.subscribe.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Subscribe', 'route' => 'theme.appearance.subscribe.dataProcessingSubscribe', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Subscribe Store', 'route' => 'theme.appearance.subscribe.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Subscribe Destroy', 'route' => 'theme.appearance.subscribe.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                        )
                     ), 
                   
                )
            ),

            (object) array(
                'label' => 'Opening',
                'route' => null,
                'icon' => 'fas fa-eye',
                'parent_id' => 0,
                'submenu' => (object) array(
                    (object) array(
                        'label' => 'Customer Opening',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'customer_openings',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Customer Opening', 'route' => 'openingSetup.customerOpening.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Customer Opening', 'route' => 'openingSetup.customerOpening.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Opening', 'route' => 'openingSetup.customerOpening.dataProcessingCustomerOpening', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Customer Opening', 'route' => 'openingSetup.customerOpening.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Customer Opening', 'route' => 'openingSetup.customerOpening.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Customer Opening', 'route' => 'openingSetup.customerOpening.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Store Opening', 'route' => 'openingSetup.customerOpening.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Customer Update Opening', 'route' => 'openingSetup.customerOpening.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                          
                        )
                    ),
                    (object) array(
                        'label' => 'Customer Opening Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'customer_opening_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'openingSetup.customerOpening.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Supplier Opening',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => "supplier_openings",
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Supplier Opening', 'route' => 'openingSetup.supplierOpening.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Supplier Opening', 'route' => 'openingSetup.supplierOpening.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Supplier Opening', 'route' => 'openingSetup.supplierOpening.dataProcessingSupplierOpening', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Supplier Opening', 'route' => 'openingSetup.supplierOpening.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Supplier Opening', 'route' => 'openingSetup.supplierOpening.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Supplier Opening', 'route' => 'openingSetup.supplierOpening.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Supplier Store Opening', 'route' => 'openingSetup.supplierOpening.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Supplier Update Opening', 'route' => 'openingSetup.supplierOpening.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
             
                        )
                    ),
                    (object) array(
                        'label' => 'Supplier Opening Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'supplier_opening_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'openingSetup.supplierOpening.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Inventory Opening',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'inventory_openings',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Opening', 'route' => 'openingSetup.inventory.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Opening', 'route' => 'openingSetup.inventory.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Inventory Opening', 'route' => 'openingSetup.inventory.dataProcessingInventory', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Inventory Opening', 'route' => 'openingSetup.inventory.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Show Inventory Opening', 'route' => 'openingSetup.inventory.show', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Inventory Opening', 'route' => 'openingSetup.inventory.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Inventory Store Opening', 'route' => 'openingSetup.inventory.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Inventory Update Opening', 'route' => 'openingSetup.inventory.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
             
                        )
                    ),
                   
                    (object) array(
                        'label' => 'Inventory Details',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'inventory_opening_details',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Add New Details', 'route' => 'openingSetup.inventory.details.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                     (object) array(
                        'label' => 'Opening Balance',
                        'route' => null,
                        'icon' => 'fa fa-th-large',
                        'parent_id' => null,
                        'table' => 'opening_balances',
                        'childMenu' => (object) array(
                            (object) array('label' => 'Opening Balance', 'route' => 'accountSetup.openingBalance.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Opening Balance Update', 'route' => 'accountSetup.openingBalance.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                   
                )
            ),

            (object) array(
                'label' => 'System Configuration',
                'route' => null,
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => (object) array(


                    (object) array(
                        'label' => 'Admin Role',
                        'route' => null,
                        'icon' => 'fa fa-lock',
                        'parent_id' => null,
                        'table' => 'admin_roles',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Role', 'route' => 'usermanage.userRole.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Role', 'route' => 'usermanage.userRole.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Role', 'route' => 'usermanage.userRole.dataProcessingRole', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Role', 'route' => 'usermanage.userRole.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Role', 'route' => 'usermanage.userRole.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Role Store', 'route' => 'usermanage.userRole.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Role Update', 'route' => 'usermanage.userRole.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                     (object) array(
                        'label' => 'User',
                        'route' => null,
                        'icon' => 'fa fa-lock',
                        'parent_id' => null,
                        'table' => 'users',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All User', 'route' => 'usermanage.user.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New User', 'route' => 'usermanage.user.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'User', 'route' => 'usermanage.user.dataProcessingUser', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit User', 'route' => 'usermanage.user.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy User', 'route' => 'usermanage.user.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'User Store', 'route' => 'usermanage.user.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'User Update', 'route' => 'usermanage.user.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Company Category ',
                        'route' => null,
                        'icon' => 'fa fa-eur',
                        'parent_id' => null,
                        'table' => 'company_categories',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Company Category', 'route' => 'settings.companyCategory.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Company Category', 'route' => 'settings.companyCategory.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Company Category', 'route' => 'settings.companyCategory.dataProcessingCompanyCategory', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Company Category', 'route' => 'settings.companyCategory.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Destroy Company Category', 'route' => 'settings.companyCategory.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Company Category Store', 'route' => 'settings.companyCategory.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Company Category Update', 'route' => 'settings.companyCategory.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                        )
                    ),
                    (object) array(
                        'label' => 'General Setup ',
                        'route' => null,
                        'icon' => 'fa fa-eur',
                        'parent_id' => null,
                        'table' => 'general_setups',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Setup', 'route' => 'settings.generalSetup.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Setup', 'route' => 'settings.generalSetup.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Setup', 'route' => 'settings.generalSetup.dataProcessingSetup', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Update Setup', 'route' => 'settings.generalSetup.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Destroy Setup', 'route' => 'settings.generalSetup.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Update Store', 'route' => 'settings.generalSetup.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Update', 'route' => 'settings.generalSetup.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Company Setup ',
                        'route' => null,
                        'icon' => 'fa fa-eur',
                        'parent_id' => null,
                        'table' => 'companies',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Company', 'route' => 'settings.company.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Company', 'route' => 'settings.company.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Company', 'route' => 'settings.company.dataProcessingCompany', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Company', 'route' => 'settings.company.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Destroy Company', 'route' => 'settings.company.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Company Store', 'route' => 'settings.company.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Company Update', 'route' => 'settings.company.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),

                        )
                    ),


                    (object) array(
                        'label' => 'Company Resource',
                        'route' => null,
                        'icon' => 'fa fa-lock',
                        'parent_id' => null,
                        'table' => 'company_resources',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Resource', 'route' => 'company.resource.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Resource', 'route' => 'company.resource.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Resource', 'route' => 'company.resource.dataProcessingCompanyResource', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Resource', 'route' => 'company.resource.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Resource', 'route' => 'company.resource.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Resource Store', 'route' => 'company.resource.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Resource Update', 'route' => 'company.resource.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Branch',
                        'route' => null,
                        'icon' => 'fa fa-cubes',
                        'parent_id' => null,
                        'table' => 'branches',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Branch', 'route' => 'settings.branch.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Branch', 'route' => 'settings.branch.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Branch', 'route' => 'settings.branch.dataProcessingBranch', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Branch', 'route' => 'settings.branch.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Branch', 'route' => 'settings.branch.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Branch Store', 'route' => 'settings.branch.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Branch Update', 'route' => 'settings.branch.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Branch Datatable', 'route' => 'settings.branch.dataProcessingBranch', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Store',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'stores',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Store', 'route' => 'settings.store.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Store', 'route' => 'settings.store.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Store', 'route' => 'settings.store.dataProcessingStore', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Store', 'route' => 'settings.store.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Store', 'route' => 'settings.store.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Store Store', 'route' => 'settings.store.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Store Update', 'route' => 'settings.store.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Department',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'departments',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Department', 'route' => 'settings.department.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Department', 'route' => 'settings.department.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Department', 'route' => 'settings.department.dataProcessingDepartment', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Department', 'route' => 'settings.department.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Department', 'route' => 'settings.department.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Department Store', 'route' => 'settings.department.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Department Update', 'route' => 'settings.department.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    

                   
                    (object) array(
                        'label' => 'Employee',
                        'route' => null,
                        'icon' => 'fa fa-eur',
                        'parent_id' => null,
                        'table' => 'employees',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Employee', 'route' => 'settings.employee.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Employee', 'route' => 'settings.employee.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Employee', 'route' => 'settings.employee.dataProcessingEmployee', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Employee', 'route' => 'settings.employee.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Employee', 'route' => 'settings.employee.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Employee Store', 'route' => 'settings.employee.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Employee Update', 'route' => 'settings.employee.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),



                    (object) array(
                        'label' => 'Fiscal Year ',
                        'route' => null,
                        'icon' => 'fa fa-eur',
                        'parent_id' => null,
                        'table' => 'fiscal_years',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Fiscal Year', 'route' => 'settings.fiscal_year.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Fiscal Year', 'route' => 'settings.fiscal_year.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Fiscal Year', 'route' => 'settings.fiscal_year.dataProcessingFiscalYear', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Fiscal Year', 'route' => 'settings.fiscal_year.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Fiscal Year', 'route' => 'settings.fiscal_year.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Fiscal Year Store', 'route' => 'settings.fiscal_year.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Fiscal Year Update', 'route' => 'settings.fiscal_year.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Currency ',
                        'route' => null,
                        'icon' => 'fa fa-eur',
                        'parent_id' => null,
                        'table' => 'currencies',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Currency', 'route' => 'settings.currency.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Currency', 'route' => 'settings.currency.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Currency', 'route' => 'settings.currency.dataProcessingCurrency', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Currency', 'route' => 'settings.currency.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Currency', 'route' => 'settings.currency.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Currency Store', 'route' => 'settings.currency.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Currency Update', 'route' => 'settings.currency.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Language ',
                        'route' => null,
                        'icon' => 'fa fa-eur',
                        'parent_id' => null,
                        'table' => 'languages',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Language', 'route' => 'settings.language.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Language', 'route' => 'settings.language.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Language', 'route' => 'settings.language.dataProcessingLanguage', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Language', 'route' => 'settings.language.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Language', 'route' => 'settings.Language.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Language Store', 'route' => 'settings.Language.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Language Update', 'route' => 'settings.Language.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    

                    (object) array(
                        'label' => 'SMTP',
                        'route' => null,
                        'icon' => 'fa fa-server',
                        'parent_id' => null,
                        'table' => 'smtps',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All SMPT', 'route' => 'settings.smpt.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New SMPT', 'route' => 'settings.smpt.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'SMPT', 'route' => 'settings.smpt.dataProcessingSmpt', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit SMPT', 'route' => 'settings.smpt.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy SMPT', 'route' => 'settings.smpt.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'SMPT Store', 'route' => 'settings.smpt.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'SMPT Update', 'route' => 'settings.smpt.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),
                    (object) array(
                        'label' => 'Vehicle',
                        'route' => null,
                        'icon' => 'fa fa-server',
                        'parent_id' => null,
                        'table' => 'vehicles',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Vehicle', 'route' => 'settings.vehicle.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Vehicle', 'route' => 'settings.vehicle.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Vehicle', 'route' => 'settings.vehicle.dataProcessingVehicles', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Vehicle', 'route' => 'settings.vehicle.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Vehicle', 'route' => 'settings.vehicle.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Vehicle Store', 'route' => 'settings.vehicle.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Vehicle Update', 'route' => 'settings.vehicle.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Division',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'divisions',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Division', 'route' => 'settings.division.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Division', 'route' => 'settings.division.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Division', 'route' => 'settings.division.dataProcessingDivision', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Division', 'route' => 'settings.division.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Division', 'route' => 'settings.division.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Division Store', 'route' => 'settings.division.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Division Update', 'route' => 'settings.division.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'District',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'districts',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All District', 'route' => 'settings.district.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New District', 'route' => 'settings.district.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'District', 'route' => 'settings.district.dataProcessingDistrict', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit District', 'route' => 'settings.district.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy District', 'route' => 'settings.district.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'District Store', 'route' => 'settings.district.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'District Update', 'route' => 'settings.district.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Upazila',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'upazilas',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Upazila', 'route' => 'settings.upazila.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Upazila', 'route' => 'settings.upazila.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Upazila', 'route' => 'settings.upazila.dataProcessingUpazila', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Upazila', 'route' => 'settings.upazila.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Upazila', 'route' => 'settings.upazila.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Upazila Store', 'route' => 'settings.upazila.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Upazila Update', 'route' => 'settings.upazila.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),

                    (object) array(
                        'label' => 'Union',
                        'route' => null,
                        'icon' => 'fa fa-home',
                        'parent_id' => null,
                        'table' => 'unions',
                        'childMenu' => (object) array(
                            (object) array('label' => 'All Union', 'route' => 'settings.union.index', 'icon' => 'fa fa-dashboard', 'navigate_status' => 1),
                            (object) array('label' => 'Add New Union', 'route' => 'settings.union.create', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Union', 'route' => 'settings.union.dataProcessingUnion', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Edit Union', 'route' => 'settings.union.edit', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Destroy Union', 'route' => 'settings.union.destroy', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Union Store', 'route' => 'settings.union.store', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                            (object) array('label' => 'Union Update', 'route' => 'settings.union.update', 'icon' => 'fa fa-dashboard', 'navigate_status' => null),
                        )
                    ),


                )
            ),

           

        );


        $parentMenu = array();
        $childMenu = array();

        foreach ((object) $parent_menu as $key => $each_parent) :
            //dd($each_parent->label);
            $navigation = new Navigation();
            $navigation->parent_id = $each_parent->parent_id;
            $navigation->label = $each_parent->label;
            $navigation->company_id = 1;
            $navigation->route = '';
            $navigation->icon = $each_parent->icon;
            $navigation->object_class = '';
            $navigation->extra_attribute = '';
            $navigation->active = "1";
            $navigation->orderBy = "1";
            $navigation->updated_by = 1;
            $navigation->created_by = 1;
            $navigation->deleted_by = null;
            $navigation->save();
            if (!empty($each_parent->submenu))
                foreach ($each_parent->submenu as $key => $each_child) :
                    $navigation_submenu = new Navigation();
                    $navigation_submenu->parent_id = $navigation->id;
                    $navigation_submenu->label = $each_child->label;
                    $navigation_submenu->route = '';
                    $navigation_submenu->company_id = 1;
                    $navigation_submenu->icon = $each_child->icon;
                    $navigation_submenu->table = $each_child->table;
                    $navigation_submenu->object_class = '';
                    $navigation_submenu->extra_attribute = '';
                    $navigation_submenu->active = "1";
                    $navigation_submenu->orderBy = "1";
                    $navigation_submenu->updated_by = 1;
                    $navigation_submenu->created_by = 1;
                    $navigation_submenu->deleted_by = null;
                    $navigation_submenu->save();
                    $formInfput = FormInput::where('table', $each_child->table)->first();
                    if (!empty($formInfput)) :
                        $formInfput->navigation_id = $navigation_submenu->id ?? 600;
                        $formInfput->save();
                    endif;
                    array_push($parentMenu, $navigation_submenu->id);
                    foreach ($each_child->childMenu as $key => $each_menu) :
                        $navigation_child = new Navigation();
                        $navigation_child->parent_id = $navigation_submenu->id;
                        $navigation_child->label = $each_menu->label;
                        $navigation_child->route = $each_menu->route;
                        $navigation_child->company_id = 1;
                        $navigation_child->navigate_status = $each_menu->navigate_status;
                        $navigation_child->icon = $each_menu->icon;
                        $navigation_child->object_class = '';
                        $navigation_child->extra_attribute = '';
                        $navigation_child->active = "1";
                        $navigation_child->orderBy = "1";
                        $navigation_child->updated_by = 1;
                        $navigation_child->created_by = 1;
                        $navigation_child->deleted_by = null;
                        $navigation_child->save();
                        array_push($childMenu, $navigation_child->id);
                    endforeach;
                endforeach;
        endforeach;

        $userRole = new UserRole();
        $userRole->company_id = 1;
        $userRole->name = 'Nptl Admin';
        $userRole->parent_id = implode(",", $parentMenu);
        $userRole->navigation_id = implode(",", $childMenu);
        $userRole->branch_id = implode(",", array(1, 2, 3, 4, 5, 6));
        $userRole->status = 'Approved';
        $userRole->save();
        $roleAccess =  new RoleAccess();
        $roleAccess->role_id = 1;
        $roleAccess->user_id = 1;
        $roleAccess->company_id = 1;
        $roleAccess->save();


        
        $formInput = FormInput::get();
        foreach($formInput as $key => $value): 
           $navigationInfo =  Navigation::where('table',$value->table)->first();
           if(!empty($navigationInfo)):
           $formInfput1 = FormInput::where('table',$value->table)->first();
           $formInfput1->navigation_id = $navigationInfo->id;
           $formInfput1->save();
           endif;
        endforeach;
        $formInput2 = FormInput::get();
        $subModules=array();
        foreach ($formInput2 as $key => $value) :
          $resourceInfo =   CompanyResource::where('table',$value->table)->first();

          if(!empty($resourceInfo)){
            $resourceInfo->navigation_id = $value->navigation_id;
            $resourceInfo->save();
          }
          if(!is_null($value->navigation_id))
           array_push($subModules,$value->navigation_id);
        endforeach;

        $companyInfo = CompanyCategory::find(1);
        $companyInfo->module_details = implode(",",$subModules);
        $companyInfo->save();




    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(FormInputSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(WarrantySeeder::class);
        $this->call(TheamColorSeeder::class);
     
        $this->call(BrandSeeder::class);
        $this->call(ServiceInvoiceSeeder::class);
        $this->call(ServiceInvoiceDetailsSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(ServiceCategorySeeder::class);
        $this->call(FormSeeder::class);
        $this->call(GeneralSetupSeeder::class);
        $this->call(ProductUnitSeeder::class);
        $this->call(AllVoucherSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(FloorSeeder::class);
        $this->call(ChartOfAccountSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(FiscalYearSeeder::class);
        $this->call(GeneralLedgerSeeder::class);
        $this->call(GeneralSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(CustomerMediaSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(SubscribeSeeder::class);
        $this->call(PosSeeder::class);
        $this->call(ContraVoucherSeeder::class);
        $this->call(ContraVoucherDetailsSeeder::class);
        $this->call(TemporaryPendingCheckSeeder::class);
        

        $this->call(JournalVoucherSeeder::class);
        $this->call(JournalVoucherLedgerSeeder::class);
        $this->call(PaymentVoucherSeeder::class);
        $this->call(PaymentVoucherLedgerSeeder::class);
        $this->call(ReceiveVoucherSeeder::class);
        $this->call(ReceiveVoucherLedgerSeeder::class);
        $this->call(PurchasesMrrSeeder::class);
        $this->call(PurchasesMrrDetailsSeeder::class);


        
        $this->call(CustomerOpeningSeeder::class);
        $this->call(CustomerOpeningDetailsSeeder::class);
        $this->call(SupplierOpeningDetailsSeeder::class);
        $this->call(SupplierOpeningSeeder::class);
        $this->call(InventoryOpeningDetailsSeeder::class);
        $this->call(InventoryOpeningSeeder::class);

        $this->call(InvoiceDetailsSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductDetailsSeeder::class);
        $this->call(ProductAttributesSeeder::class);
        $this->call(ProductGallerySeeder::class);
        $this->call(DeliveryChallanDetailsSeeder::class);
        $this->call(DeliveryChallanSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(PurchasesDetailsSeeder::class);
        $this->call(StockSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(TransferDetailsSeeder::class);
        $this->call(TranspferSeeder::class);
        $this->call(UserManageSeeder::class);
        $this->call(InoviceSeeder::class);
        $this->call(PurchasesSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(SmtpSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(UnionSeeder::class);
        $this->call(UpazilaSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(BatchNumberSeeder::class);
        $this->call(InventoryAdjustmentSeeder::class);
        $this->call(InventoryAdjustmentDetailsSeeder::class);


        $this->call(AdminRoleSeeder::class);
        $this->call(SmsSeeder::class);
        $this->call(MailboxSeeder::class);
        $this->call(PurchasesOrderSeeder::class);
        $this->call(PurchasesOrderDetailsSeeder::class);
        $this->call(ReferenceSeeder::class);
        $this->call(ServiceQuatationDetailsSeeder::class);
        $this->call(ServiceQuatationSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(SalesSeeder::class);
        $this->call(SalesDetailsSeeder::class);
        $this->call(TaskCategorySeeder::class);
        $this->call(TaskCreateSeeder::class);
        $this->call(TaskStatusSeeder::class);
        $this->call(SalesQuatationSeeder::class);
        $this->call(SalesQuatationDetailsSeeder::class);
        $this->call(PurchaseRequisitionDetailsSeeder::class);
        $this->call(PurchaseRequisitionSeeder::class);
        $this->call(AccountTypeSeeder::class);
        $this->call(PurchasesPaymentSeeder::class);
        $this->call(SalePaymentSeeder::class);
        $this->call(SalesLonSeeder::class);
        $this->call(SalesLonDetailsSeeder::class);

        //return
        $this->call(SaleReturnDetailSeeder::class);
        $this->call(SaleReturnSeeder::class);
        $this->call(PurchasesReturnSeeder::class);
        $this->call(PurchasesReturnDetailSeeder::class);
        $this->call(SalesLoanReturnSeeder::class);
        $this->call(SalesLoanReturnDetailsSeeder::class);
      
        $this->call(ReportModelSeeder::class);
        $this->call(CompanyCategorySeeder::class);
        $this->call(CustomerGroupSeeder::class);
        $this->call(SalePendingChequeSeeder::class);
        $this->call(PurchasesPendingChequeSeeder::class);
        $this->call(ProductSummarySeeder::class);
        $this->call(GeneralTableSeeder::class);
        $this->call(SupplierGroupSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(PaymentStatusSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(CompanyResourceSeeder::class);
        $this->call(NavigationSeeder::class);
       



        // $this->call(SmtpSeeder::class);

        // \App\Models\User::factory(10)->create();
    }
}
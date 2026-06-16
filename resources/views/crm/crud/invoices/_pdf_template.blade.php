<style>
.tax-invoice-wrapper { font-family: 'Helvetica', 'Arial', sans-serif; color:#222; }
.tax-invoice-wrapper * { box-sizing: border-box; }
.ti-header { display:flex; justify-content:space-between; align-items:flex-start; padding-bottom:14px; border-bottom:2px solid #222; margin-bottom:14px; }
.ti-company { font-size:20px; font-weight:800; color:#1f2c4d; }
.ti-company-sub { font-size:11px; color:#555; margin-top:2px; line-height:1.4; }
.ti-meta { text-align:right; font-size:12px; line-height:1.5; }
.ti-meta strong { color:#1f2c4d; }
.ti-billto { display:flex; justify-content:space-between; padding:10px 0; gap:20px; flex-wrap:wrap; }
.ti-billto-block { flex:1; min-width:240px; font-size:12px; }
.ti-billto-block h6 { font-size:12px; text-transform:uppercase; color:#666; font-weight:700; margin-bottom:6px; letter-spacing:.5px; }
.ti-table { width:100%; border-collapse:collapse; font-size:12px; margin-top:10px; }
.ti-table thead th { background:#1f2c4d; color:#fff; padding:8px; text-align:left; font-weight:600; font-size:11px; }
.ti-table thead th.right { text-align:right; }
.ti-table thead th.center { text-align:center; }
.ti-table tbody td { padding:8px; border-bottom:1px solid #e0e0e0; vertical-align:top; }
.ti-table tbody td.right { text-align:right; }
.ti-table tbody td.center { text-align:center; }
.ti-table tbody tr:nth-child(even) { background:#fafafa; }
.ti-totals { width:320px; margin-left:auto; margin-top:14px; font-size:13px; }
.ti-totals .row { display:flex; justify-content:space-between; padding:5px 0; border-bottom:1px dotted #ccc; }
.ti-totals .row.total { border-top:2px solid #222; border-bottom:2px solid #222; font-weight:700; font-size:15px; padding:8px 0; background:#f4f6fa; padding-left:6px; }
.ti-remarks { margin-top:18px; padding:10px; background:#f8f9fc; border-left:3px solid #1f2c4d; font-size
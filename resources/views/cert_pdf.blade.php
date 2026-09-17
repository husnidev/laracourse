<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 0; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: serif; }
    .certificate {
        width: 800px;
        height: 565px;
        margin: 0 auto;
        padding: 40px;
        border: 8px double #d97706;
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        position: relative;
        overflow: hidden;
    }
    .border-inner {
        border: 2px solid #d97706;
        width: 100%;
        height: 100%;
        padding: 30px 50px;
        position: relative;
    }
    .corner {
        position: absolute;
        width: 60px;
        height: 60px;
        border-color: #d97706;
    }
    .corner-tl { top: 8px; left: 8px; border-top: 3px solid; border-left: 3px solid; }
    .corner-tr { top: 8px; right: 8px; border-top: 3px solid; border-right: 3px solid; }
    .corner-bl { bottom: 8px; left: 8px; border-bottom: 3px solid; border-left: 3px solid; }
    .corner-br { bottom: 8px; right: 8px; border-bottom: 3px solid; border-right: 3px solid; }
    .header { text-align: center; margin-bottom: 10px; }
    .icon { font-size: 40px; color: #d97706; margin-bottom: 5px; }
    .title { font-size: 13px; letter-spacing: 6px; color: #92400e; text-transform: uppercase; font-weight: bold; }
    .subtitle { font-size: 10px; color: #b45309; letter-spacing: 3px; margin-top: 3px; }
    .given-to { font-size: 10px; color: #78716c; margin-top: 10px; margin-bottom: 5px; }
    .student-name { font-size: 30px; font-weight: bold; color: #1c1917; margin-bottom: 5px; font-family: "Georgia", serif; }
    .desc { font-size: 11px; color: #78716c; margin-bottom: 10px; }
    .course-title { font-size: 18px; font-weight: bold; color: #6d28d9; margin-bottom: 15px; }
    .details { display: table; width: 100%; margin-bottom: 15px; }
    .detail-row { display: table-row; }
    .detail-item { display: table-cell; width: 50%; padding: 5px 10px; text-align: center; }
    .detail-label { font-size: 9px; color: #a8a29e; text-transform: uppercase; letter-spacing: 1px; }
    .detail-value { font-size: 11px; color: #1c1917; font-weight: bold; margin-top: 2px; }
    .footer { text-align: center; border-top: 1px solid #d97706; padding-top: 10px; margin-top: 10px; }
    .footer-text { font-size: 9px; color: #a8a29e; letter-spacing: 2px; }
    .date-line { font-size: 10px; color: #78716c; margin-top: 5px; }
</style>
</head>
<body>
    <div class="certificate">
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>
    <div class="border-inner">
        <div class="header">
            <div class="icon">&#127942;</div>
            <div class="title">Certificate of Completion</div>
            <div class="subtitle">Sertifikat Penyelesaian</div>
            <div class="given-to">Diberikan kepada</div>
            <div class="student-name"><?= htmlspecialchars($cert->student_name) ?></div>
            <div class="desc">telah berhasil menyelesaikan kursus</div>
            <div class="course-title"><?= htmlspecialchars($cert->course_title) ?></div>
        </div>
        <div class="details">
            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Kategori</div>
                    <div class="detail-value"><?= htmlspecialchars($cert->category_name ?? '-') ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Instruktur</div>
                    <div class="detail-value"><?= htmlspecialchars($cert->teacher_name) ?></div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">No. Sertifikat</div>
                    <div class="detail-value" style="font-family: monospace; font-size: 10px;"><?= htmlspecialchars($cert->certificate_no) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tanggal Terbit</div>
                    <div class="detail-value"><?= date('d F Y', strtotime($cert->issue_date)) ?></div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="footer-text">E-LEARNING PLATFORM</div>
        </div>
    </div>
</div>

</body>
</html>




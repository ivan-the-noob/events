function printModalContent(id) {
    var element = document.getElementById("printContent-" + id);
    var printButton = document.querySelector('#printContent-' + id + ' button');
    printButton.style.display = 'none';
    html2canvas(element).then(function(canvas) {
        var imgData = canvas.toDataURL('image/png');
        printButton.style.display = 'inline-block';
        var printWindow = window.open('', '', 'height=600,width=800');
        
        printWindow.document.write('<html><head><title>Invoice</title></head><body style="text-align:center;">');
        printWindow.document.write('<img src="' + imgData + '" style="max-width:100%; max-height:100%;" />');
        printWindow.document.write('</body></html>');

        printWindow.document.close();

        printWindow.onload = function() {
            printWindow.print();
        };
    });
}
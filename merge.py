from PyPDF2 import PdfFileMerger
import os,warnings

warnings.filterwarnings("ignore")

# Read all Downloaded Files From Directory.
pdfs = os.listdir("files")

merger = PdfFileMerger()

# Append all the files one by one in to buffer to write.
for pdf in pdfs:
    merger.append("files/%s" % pdf)

# Merge All files in merged_pdf.pdf file.
merger.write("merged_pdf.pdf")

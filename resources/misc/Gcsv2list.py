"""
Written by Carson Hynes

Usage: python csv2list.py

Google Invite List Guidelines:
    Top two rows are for labels/titles. Will not be parsed.
    Left-most column for Brothers (Inviters). Will not be parsed.

Google Export Instructions:
    Open the invite list in Google Sheets
    Click "Download as -> Comma-separated Values (.csv, current sheet)
    Rename file to names.csv and place in the same folder as this file
    Run this file using the "Usage" section at the top of this document

"""

infile = open("names.csv", 'r')

outputArray = "var names = [\n"

lineCount = 0

for line in infile:
    outLine = ""
    if lineCount != 0 and lineCount != 1:
        splitLine = line.split(",")
        brotherCheck = 0
        for invite in splitLine:
            if brotherCheck != 0 and invite.rstrip() != "":
                outLine = invite
                outLine = '\t\"' + outLine.rstrip() + '\",\n'
                outputArray += outLine
            brotherCheck = 1
    lineCount += 1


outputArray = outputArray[: -2]

outputArray += '\n];'

outFile = open('list.js', 'w')

outFile.write(outputArray)

outFile.close()
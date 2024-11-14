set /p USER_INPUT=project: 
"C:\Program Files\WinRAR\rar.exe" a ../%USER_INPUT%.rar %USER_INPUT%
cd %USER_INPUT%
git add .
git commit -m"auto"
git push 

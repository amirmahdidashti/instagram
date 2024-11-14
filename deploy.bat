mkdir ../core
copy * ../core

"C:\Program Files\WinRAR\rar.exe" a ../instagram.rar ../core

git add .
git commit -m"auto"
git push 

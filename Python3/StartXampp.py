import subprocess

xampp_path = r"C:\xampp\xampp_start.exe"

subprocess.Popen(xampp_path, shell=True)

print("XAMPP gestarted")
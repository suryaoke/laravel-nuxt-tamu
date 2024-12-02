export default function useAuth() {
    const user = useState('auth-user', () => null)

    const { errorBag, transformValidationErrors, resetErrorBag } = useError()

    const { api, csrf } = useAxios()

    // Fungsi untuk login
    function login(userForm) {
        resetErrorBag(); // Reset error bag jika ada

        // Mengambil token CSRF dulu sebelum melanjutkan request
        csrf().then(() => {
            api.post("api/login", userForm).then(({ data }) => {
                // Pastikan token ada dalam respons data
                const token = data.data.token;  // Mendapatkan token dari respons

                if (token) {
                    // Simpan token di cookie atau localStorage
                    useCookie('token', { value: token, maxAge: 60 * 60 * 24 }).value = token;  // Cookie selama 24 jam
                
                    // Simpan data user jika diperlukan
                    user.value = data.data.user;

                    // Redirect ke halaman dashboard setelah login berhasil
                    console.log('Login berhasil:', data);
                    navigateTo("/dashboard");
                } else {
                    console.log('Token tidak ditemukan dalam respons');
                }
            }).catch(err => {
                console.log('Login error:', err.response);  // Tambahkan untuk debug jika ada error
                transformValidationErrors(err.response);  // Tangani error dari server
            });
        });
    }

    // Fungsi untuk register
    function register(userForm) {
        resetErrorBag();
        csrf().then(() => {
            api.post("api/register", userForm).then(({ data }) => {
                // Arahkan pengguna ke halaman login setelah registrasi berhasil
                navigateTo("/"); 
            }).catch(err => {
                transformValidationErrors(err.response);
            });
        });
    }

    // Fungsi untuk logout
   function logout() {
    // Ambil token dari cookie
    const token = useCookie('token').value;

    if (token) {
        api.post("api/logout", {}, {
            headers: {
                Authorization: `Bearer ${token}`  // Kirimkan token di header Authorization
            }
        }).then(() => {
            // Setelah logout berhasil, hapus token dari cookie
            useCookie('token').value = '';  // Hapus token
            user.value = null;  // Hapus data user

            // Redirect ke halaman login setelah logout berhasil
            navigateTo("/"); 
            console.log('Logout berhasil');
        }).catch(err => {
            console.log('Logout error:', err.response);  // Tangani error dari server
        });
    } else {
        console.log('Token tidak ditemukan');
    }
}


    return { login, register, logout, errorBag, user }
}

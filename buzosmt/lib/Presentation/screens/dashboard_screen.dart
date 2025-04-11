import 'package:buzosmt/main.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'login_screen.dart';

class Dashboard extends StatelessWidget {
  const Dashboard({super.key});

  Future<void> _logout(BuildContext context) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('token'); // elimina el token guardado

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(builder: (context) => const MyHomePage()),
    );
  }
  Widget _buildDrawerItem(IconData icon, String text) {
  return ListTile(
    leading: Icon(icon, color: Colors.white),
    title: Text(text, style: const TextStyle(color: Colors.white)),
    onTap: () {
      // Acción al pulsar
    },
  );
}

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: true, // Ensure the menu icon is shown
        title: const Text('Home'),
      ),
      drawer: Drawer(
  child: Container(
    decoration: const BoxDecoration(
      gradient: LinearGradient(
        begin: Alignment.topCenter,
        end: Alignment.bottomCenter,
        colors: [
          Color(0xFF0D3D4A),
          Color(0xFF34E69F),
        ],
      ),
    ),
    child: Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 60),
        // Avatar + nombre + rol
        Center(
          child: Column(
            children: const [
              CircleAvatar(
                radius: 30,
                backgroundColor: Colors.white,
                child: Icon(Icons.person, size: 35, color: Colors.grey),
              ),
              SizedBox(height: 8),
              Text(
                'Harold',
                style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
              ),
              Text(
                'Jefe Producción',
                style: TextStyle(color: Colors.white70, fontSize: 12),
              ),
            ],
          ),
        ),

        const Divider(color: Colors.white30, height: 40),

        // Menú
        Expanded(
          child: ListView(
            children: [
              _buildDrawerItem(Icons.dashboard, 'Dashboard'),
              ExpansionTile(
                leading: const Icon(Icons.factory, color: Colors.white),
                title: const Text('Producción', style: TextStyle(color: Colors.white)),
                children: [
                  ListTile(
                    title: const Text('Submenú 1', style: TextStyle(color: Colors.white70)),
                    onTap: () {},
                  ),
                ],
              ),
              _buildDrawerItem(Icons.calendar_today, 'Tareas'),
              _buildDrawerItem(Icons.settings, 'Configuración'),
            ],
          ),
        ),
      ],
    ),
  ),
)
,
      body: Center(
        child: ElevatedButton(
          onPressed: () => _logout(context),
          child: const Text('Cerrar sesión'),
        ),
      ),
    );
  }
}

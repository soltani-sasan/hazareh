import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'theme/app_theme.dart';
import 'screens/splash_screen.dart';
import 'screens/home_screen.dart';
import 'screens/news_screen.dart';
import 'screens/announcements_screen.dart';
import 'screens/counseling_screen.dart';
import 'screens/conference_screen.dart';
import 'screens/login_screen.dart';
import 'screens/profile_screen.dart';
import 'screens/registration_check_screen.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const HazarehApp());
}

class HazarehApp extends StatelessWidget {
  const HazarehApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'هنرستان هزاره صنعت',
      debugShowCheckedModeBanner: false,
      theme: AppTheme.theme,
      builder: (context, child) => Directionality(
        textDirection: TextDirection.rtl,
        child: child!,
      ),
      initialRoute: '/splash',
      routes: {
        '/splash':    (_) => const SplashScreen(),
        '/':          (_) => const MainShell(),
        '/news':      (_) => const NewsScreen(),
        '/announcements': (_) => const AnnouncementsScreen(),
        '/counseling':(_) => const CounselingScreen(),
        '/conference':(_) => const ConferenceScreen(),
        '/login':     (_) => const LoginScreen(),
        '/profile':   (_) => const ProfileScreen(),
        '/reg-check': (_) => const RegistrationCheckScreen(),
      },
    );
  }
}

/// پوسته اصلی با BottomNavigationBar
class MainShell extends StatefulWidget {
  const MainShell({super.key});
  @override
  State<MainShell> createState() => _MainShellState();
}

class _MainShellState extends State<MainShell> {
  int _idx = 0;

  final List<Widget> _pages = const [
    HomeScreen(),
    NewsScreen(),
    AnnouncementsScreen(),
    ConferenceScreen(),
    ProfileScreen(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: IndexedStack(index: _idx, children: _pages),
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _idx,
        onTap: (i) => setState(() => _idx = i),
        type: BottomNavigationBarType.fixed,
        selectedItemColor: AppColors.accent,
        unselectedItemColor: Colors.grey.shade500,
        selectedFontSize: 11,
        unselectedFontSize: 11,
        items: const [
          BottomNavigationBarItem(icon: Icon(Icons.home_outlined), activeIcon: Icon(Icons.home), label: 'خانه'),
          BottomNavigationBarItem(icon: Icon(Icons.article_outlined), activeIcon: Icon(Icons.article), label: 'اخبار'),
          BottomNavigationBarItem(icon: Icon(Icons.campaign_outlined), activeIcon: Icon(Icons.campaign), label: 'اعلانات'),
          BottomNavigationBarItem(icon: Icon(Icons.emoji_events_outlined), activeIcon: Icon(Icons.emoji_events), label: 'همایش'),
          BottomNavigationBarItem(icon: Icon(Icons.person_outline), activeIcon: Icon(Icons.person), label: 'پروفایل'),
        ],
      ),
    );
  }
}

import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

/// هویت بصری اپلیکیشن — هماهنگ با وب‌سایت (آبی صنعتی + کهربایی)
class AppColors {
  static const primary = Color(0xFF1A3A5C);
  static const primaryLight = Color(0xFF2563A8);
  static const primaryDark = Color(0xFF0F2338);
  static const accent = Color(0xFFE07B00);
  static const accentLight = Color(0xFFF59E0B);
  static const bg = Color(0xFFF8F9FC);
  static const success = Color(0xFF059669);
  static const danger = Color(0xFFDC2626);
  static const textMuted = Color(0xFF64748B);
}

class AppTheme {
  static ThemeData get theme {
    final base = ThemeData(
      useMaterial3: true,
      colorScheme: ColorScheme.fromSeed(
        seedColor: AppColors.primary,
        primary: AppColors.primary,
        secondary: AppColors.accent,
      ),
      scaffoldBackgroundColor: AppColors.bg,
      fontFamily: GoogleFonts.vazirmatn().fontFamily,
    );

    return base.copyWith(
      appBarTheme: const AppBarTheme(
        backgroundColor: AppColors.primary,
        foregroundColor: Colors.white,
        elevation: 0,
        centerTitle: true,
      ),
      elevatedButtonTheme: ElevatedButtonThemeData(
        style: ElevatedButton.styleFrom(
          backgroundColor: AppColors.accent,
          foregroundColor: Colors.white,
          padding: const EdgeInsets.symmetric(vertical: 14, horizontal: 20),
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        ),
      ),
      inputDecorationTheme: InputDecorationTheme(
        filled: true,
        fillColor: Colors.white,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: const BorderSide(color: Color(0xFFCBD5E1)),
        ),
        contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
      ),
      cardTheme: CardThemeData(
        elevation: 1,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
      ),
    );
  }
}

import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

/// سرویس مرکزی ارتباط با REST API هنرستان هزاره صنعت
class ApiService {
  // ⚠️ پیش از انتشار، آدرس واقعی دامنه را وارد کنید
  static const String baseUrl = 'http://127.0.0.1:8000/api/v1';
  static const String storageUrl = 'https://hazareh.ir/storage/';

  static Future<String?> _token() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('auth_token');
  }

  static Future<Map<String, String>> _headers({bool auth = false}) async {
    final headers = {'Accept': 'application/json', 'Content-Type': 'application/json'};
    if (auth) {
      final t = await _token();
      if (t != null) headers['Authorization'] = 'Bearer $t';
    }
    return headers;
  }

  static Future<bool> isLoggedIn() async => (await _token()) != null;

  // ── خانه ─────────────────────────────────────────────
  static Future<Map<String,dynamic>> getHome() async {
    final r = await http.get(Uri.parse('$baseUrl/home'), headers: await _headers());
    return jsonDecode(r.body);
  }

  // ── اخبار ─────────────────────────────────────────────
  static Future<Map<String,dynamic>> getNews({String? category}) async {
    final uri = Uri.parse('$baseUrl/news').replace(
        queryParameters: category != null ? {'category': category} : null);
    final r = await http.get(uri, headers: await _headers());
    return jsonDecode(r.body);
  }

  static Future<Map<String,dynamic>> getNewsDetail(String slug) async {
    final r = await http.get(Uri.parse('$baseUrl/news/$slug'), headers: await _headers());
    return jsonDecode(r.body);
  }

  // ── اعلانات ───────────────────────────────────────────
  static Future<Map<String,dynamic>> getAnnouncements() async {
    final r = await http.get(Uri.parse('$baseUrl/announcements'), headers: await _headers());
    return jsonDecode(r.body);
  }

  // ── احراز هویت ────────────────────────────────────────
  static Future<Map<String,dynamic>> login(String nationalId, String password) async {
    final r = await http.post(Uri.parse('$baseUrl/auth/login'),
        headers: await _headers(),
        body: jsonEncode({'national_id': nationalId, 'password': password}));
    final data = jsonDecode(r.body);
    if (r.statusCode == 200 && data['success'] == true) {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', data['token']);
    }
    return data;
  }

  static Future<void> logout() async {
    final h = await _headers(auth: true);
    await http.post(Uri.parse('$baseUrl/auth/logout'), headers: h);
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
  }

  static Future<Map<String,dynamic>> getMe() async {
    final r = await http.get(Uri.parse('$baseUrl/auth/me'), headers: await _headers(auth: true));
    return jsonDecode(r.body);
  }

  // ── پیش‌ثبت‌نام ───────────────────────────────────────
  static Future<Map<String,dynamic>> checkRegistrationStatus(String nationalId) async {
    final r = await http.get(Uri.parse('$baseUrl/pre-register/check/$nationalId'),
        headers: await _headers());
    return jsonDecode(r.body);
  }

  // ── مشاوره ────────────────────────────────────────────
  static Future<Map<String,dynamic>> submitCounseling(Map<String,dynamic> data) async {
    final r = await http.post(Uri.parse('$baseUrl/counseling'),
        headers: await _headers(), body: jsonEncode(data));
    return jsonDecode(r.body);
  }

  static Future<Map<String,dynamic>> trackCounseling(String nid, String mobile) async {
    final r = await http.post(Uri.parse('$baseUrl/counseling/track'),
        headers: await _headers(),
        body: jsonEncode({'national_id': nid, 'mobile': mobile}));
    return jsonDecode(r.body);
  }

  // ── همایش ─────────────────────────────────────────────
  static Future<Map<String,dynamic>> getConference() async {
    final r = await http.get(Uri.parse('$baseUrl/conference'), headers: await _headers());
    return jsonDecode(r.body);
  }

  static Future<Map<String,dynamic>> registerConference(Map<String,dynamic> data) async {
    final r = await http.post(Uri.parse('$baseUrl/conference/register'),
        headers: await _headers(), body: jsonEncode(data));
    return jsonDecode(r.body);
  }

  // ── پنل کاربری ────────────────────────────────────────
  static Future<Map<String,dynamic>> getDashboard() async {
    final r = await http.get(Uri.parse('$baseUrl/panel/dashboard'),
        headers: await _headers(auth: true));
    return jsonDecode(r.body);
  }
}

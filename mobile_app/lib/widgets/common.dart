import 'package:flutter/material.dart';
import '../theme/app_theme.dart';

class PrimaryButton extends StatelessWidget {
  final String label;
  final VoidCallback? onPressed;
  final bool loading;
  const PrimaryButton({super.key, required this.label, this.onPressed, this.loading = false});

  @override
  Widget build(BuildContext context) => SizedBox(
    width: double.infinity,
    height: 50,
    child: ElevatedButton(
      onPressed: loading ? null : onPressed,
      child: loading
          ? const SizedBox(width:20,height:20,child:CircularProgressIndicator(color:Colors.white,strokeWidth:2))
          : Text(label, style: const TextStyle(fontSize:16, fontWeight: FontWeight.bold)),
    ),
  );
}

class SectionHeader extends StatelessWidget {
  final String eyebrow;
  final String title;
  const SectionHeader({super.key, required this.eyebrow, required this.title});

  @override
  Widget build(BuildContext context) => Padding(
    padding: const EdgeInsets.symmetric(vertical: 16),
    child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
      Text(eyebrow, style: TextStyle(fontSize:12, fontWeight:FontWeight.w600,
          color: AppColors.accent, letterSpacing: 1.2)),
      const SizedBox(height: 4),
      Text(title, style: TextStyle(fontSize:20, fontWeight:FontWeight.bold,
          color: AppColors.primary)),
      const SizedBox(height: 6),
      Container(width:50, height:3, decoration:BoxDecoration(
          color: AppColors.accent, borderRadius: BorderRadius.circular(2))),
    ]),
  );
}

class InfoTile extends StatelessWidget {
  final IconData icon;
  final String label;
  final String value;
  const InfoTile({super.key, required this.icon, required this.label, required this.value});

  @override
  Widget build(BuildContext context) => Padding(
    padding: const EdgeInsets.symmetric(vertical: 6),
    child: Row(children: [
      Icon(icon, size:18, color: AppColors.accent),
      const SizedBox(width: 8),
      Text('$label: ', style: const TextStyle(fontWeight:FontWeight.bold, fontSize:14)),
      Expanded(child: Text(value, style: const TextStyle(fontSize:14, color:Color(0xFF475569)))),
    ]),
  );
}

class StatusBadge extends StatelessWidget {
  final String label;
  final Color color;
  const StatusBadge({super.key, required this.label, required this.color});

  @override
  Widget build(BuildContext context) => Container(
    padding: const EdgeInsets.symmetric(horizontal:10, vertical:4),
    decoration: BoxDecoration(
      color: color.withOpacity(0.12),
      borderRadius: BorderRadius.circular(20),
      border: Border.all(color: color.withOpacity(0.3)),
    ),
    child: Text(label, style: TextStyle(fontSize:12, color:color, fontWeight:FontWeight.bold)),
  );
}

class EmptyState extends StatelessWidget {
  final IconData icon;
  final String message;
  const EmptyState({super.key, required this.icon, required this.message});

  @override
  Widget build(BuildContext context) => Center(
    child: Padding(padding: const EdgeInsets.all(32), child: Column(
      mainAxisSize: MainAxisSize.min,
      children: [
        Icon(icon, size:56, color:Colors.grey.shade400),
        const SizedBox(height:16),
        Text(message, textAlign:TextAlign.center,
            style: TextStyle(fontSize:15, color:Colors.grey.shade600)),
      ],
    )),
  );
}

class LoadingState extends StatelessWidget {
  const LoadingState({super.key});
  @override
  Widget build(BuildContext context) => const Center(
    child: CircularProgressIndicator());
}

class NewsCard extends StatelessWidget {
  final String title;
  final String category;
  final String? date;
  final String? imageUrl;
  final VoidCallback onTap;
  const NewsCard({super.key, required this.title, required this.category,
    this.date, this.imageUrl, required this.onTap});

  @override
  Widget build(BuildContext context) => Card(
    margin: const EdgeInsets.symmetric(horizontal:16, vertical:6),
    child: InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(14),
      child: Column(crossAxisAlignment:CrossAxisAlignment.start, children:[
        if (imageUrl != null) ClipRRect(
          borderRadius: const BorderRadius.vertical(top:Radius.circular(14)),
          child: Image.network(imageUrl!, height:160, width:double.infinity,
              fit:BoxFit.cover,
              errorBuilder:(c,e,s)=> Container(height:160,color:Colors.grey.shade200,
                  child:Icon(Icons.image, size:40, color:Colors.grey.shade400))),
        ),
        Padding(
          padding: const EdgeInsets.all(12),
          child: Column(crossAxisAlignment:CrossAxisAlignment.start, children:[
            Container(padding:const EdgeInsets.symmetric(horizontal:8,vertical:3),
              decoration:BoxDecoration(color:AppColors.accent.withOpacity(0.1),
                  borderRadius:BorderRadius.circular(4)),
              child:Text(category, style:TextStyle(fontSize:11,color:AppColors.accent,
                  fontWeight:FontWeight.bold))),
            const SizedBox(height:8),
            Text(title, style:const TextStyle(fontSize:15,fontWeight:FontWeight.bold),
                maxLines:2, overflow:TextOverflow.ellipsis),
            if (date!=null) ...[
              const SizedBox(height:4),
              Text(date!, style:TextStyle(fontSize:12,color:Colors.grey.shade500)),
            ],
          ]),
        ),
      ]),
    ),
  );
}

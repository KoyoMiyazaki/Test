from django.views import generic
# from django.shortcuts import render

class HomeView(generic.TemplateView):
    template_name = "static_pages/home.html"

class HelpView(generic.TemplateView):
    template_name = "static_pages/help.html"

class AboutView(generic.TemplateView):
    template_name = "static_pages/about.html"

class ContactView(generic.TemplateView):
    template_name = "static_pages/contact.html"
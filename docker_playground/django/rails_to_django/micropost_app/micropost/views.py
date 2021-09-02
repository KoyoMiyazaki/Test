from django.views import generic
# from django.shortcuts import render

class HomeView(generic.TemplateView):
    template_name = "home.html"

class HelpView(generic.TemplateView):
    template_name = "help.html"

class AboutView(generic.TemplateView):
    template_name = "about.html"

class ContactView(generic.TemplateView):
    template_name = "contact.html"
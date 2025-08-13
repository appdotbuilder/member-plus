import React from 'react';
import { Link, Head } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Props {
    auth?: {
        user?: {
            id: number;
            name: string;
            email: string;
        };
    };
    [key: string]: unknown;
}

export default function Welcome({ auth }: Props) {
    return (
        <>
            <Head title="Insurance & Lifestyle Membership - Your Complete Protection & Benefits Platform" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
                {/* Header */}
                <header className="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-2">
                                <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <span className="text-white font-bold text-sm">IM</span>
                                </div>
                                <span className="text-xl font-bold text-gray-900">InsureMember</span>
                            </div>
                            
                            <nav className="hidden md:flex items-center space-x-6">
                                <a href="#features" className="text-gray-600 hover:text-blue-600 font-medium transition-colors">Features</a>
                                <a href="#benefits" className="text-gray-600 hover:text-blue-600 font-medium transition-colors">Benefits</a>
                                <a href="#membership" className="text-gray-600 hover:text-blue-600 font-medium transition-colors">Membership</a>
                                {auth?.user ? (
                                    <Link href="/dashboard">
                                        <Button className="bg-blue-600 hover:bg-blue-700">
                                            Dashboard
                                        </Button>
                                    </Link>
                                ) : (
                                    <div className="flex items-center space-x-3">
                                        <Link href="/login">
                                            <Button variant="ghost" className="text-gray-700 hover:text-blue-600">
                                                Sign In
                                            </Button>
                                        </Link>
                                        <Link href="/register">
                                            <Button className="bg-blue-600 hover:bg-blue-700">
                                                Join Now
                                            </Button>
                                        </Link>
                                    </div>
                                )}
                            </nav>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="relative py-20 lg:py-28">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center">
                            <div className="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full text-blue-800 text-sm font-medium mb-6">
                                🛡️ Complete Protection & Lifestyle Benefits
                            </div>
                            
                            <h1 className="text-4xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                                Your All-in-One
                                <span className="text-blue-600"> Insurance &</span>
                                <br />
                                <span className="text-blue-600">Lifestyle Membership</span>
                            </h1>
                            
                            <p className="text-xl text-gray-600 max-w-3xl mx-auto mb-10 leading-relaxed">
                                Experience comprehensive insurance protection combined with exclusive lifestyle benefits. 
                                Manage policies, earn loyalty points, book appointments, and access premium services all in one place.
                            </p>
                            
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                {auth?.user ? (
                                    <Link href="/dashboard">
                                        <Button size="lg" className="bg-blue-600 hover:bg-blue-700 text-lg px-8 py-4">
                                            🚀 Go to Dashboard
                                        </Button>
                                    </Link>
                                ) : (
                                    <>
                                        <Link href="/register">
                                            <Button size="lg" className="bg-blue-600 hover:bg-blue-700 text-lg px-8 py-4">
                                                🎯 Start Your Membership
                                            </Button>
                                        </Link>
                                        <Link href="/login">
                                            <Button variant="outline" size="lg" className="text-lg px-8 py-4 border-blue-200 hover:bg-blue-50">
                                                👋 Member Sign In
                                            </Button>
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </section>

                {/* Key Stats */}
                <section className="py-16 bg-white/60 backdrop-blur-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                            <div className="text-center">
                                <div className="text-3xl font-bold text-blue-600">500K+</div>
                                <div className="text-gray-600 mt-1">Protected Members</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-blue-600">$2.5B</div>
                                <div className="text-gray-600 mt-1">Claims Processed</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-blue-600">99.8%</div>
                                <div className="text-gray-600 mt-1">Satisfaction Rate</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-blue-600">24/7</div>
                                <div className="text-gray-600 mt-1">Support Available</div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Features Section */}
                <section id="features" className="py-20">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-16">
                            <h2 className="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                                Everything You Need in One Platform
                            </h2>
                            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                                Comprehensive insurance management combined with exclusive lifestyle benefits and rewards.
                            </p>
                        </div>

                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div className="bg-white/80 backdrop-blur-sm rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                                <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">🛡️</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">Insurance Policies</h3>
                                <p className="text-gray-600 leading-relaxed">
                                    View, manage, and renew all your insurance policies in one secure dashboard. 
                                    Track coverage details, premiums, and policy status.
                                </p>
                            </div>

                            <div className="bg-white/80 backdrop-blur-sm rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                                <div className="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">📋</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">Claims Management</h3>
                                <p className="text-gray-600 leading-relaxed">
                                    Submit and track insurance claims with ease. Real-time updates on claim status 
                                    and direct communication with claim specialists.
                                </p>
                            </div>

                            <div className="bg-white/80 backdrop-blur-sm rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                                <div className="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">⭐</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">Loyalty Rewards</h3>
                                <p className="text-gray-600 leading-relaxed">
                                    Earn points for every policy purchase, claim processed, and referral made. 
                                    Redeem points for exclusive benefits and discounts.
                                </p>
                            </div>

                            <div className="bg-white/80 backdrop-blur-sm rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                                <div className="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">🦷</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">Dental Appointments</h3>
                                <p className="text-gray-600 leading-relaxed">
                                    Book dental appointments directly through the platform. Access preferred 
                                    provider networks and member-exclusive pricing.
                                </p>
                            </div>

                            <div className="bg-white/80 backdrop-blur-sm rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                                <div className="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">🚗</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">Lifestyle Products</h3>
                                <p className="text-gray-600 leading-relaxed">
                                    Explore special car insurance packages, health products, and wellness services 
                                    at member-exclusive rates and terms.
                                </p>
                            </div>

                            <div className="bg-white/80 backdrop-blur-sm rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                                <div className="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">👤</span>
                                </div>
                                <h3 className="text-xl font-semibold text-gray-900 mb-3">Member Profile</h3>
                                <p className="text-gray-600 leading-relaxed">
                                    Maintain your personal membership details, emergency contacts, and preferences. 
                                    Track your membership tier and benefits.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Membership Tiers */}
                <section id="membership" className="py-20 bg-gray-50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-16">
                            <h2 className="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                                Choose Your Membership Tier
                            </h2>
                            <p className="text-xl text-gray-600">
                                Unlock more benefits as you progress through our membership levels
                            </p>
                        </div>

                        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                            {[
                                { tier: 'Bronze', color: 'amber', perks: ['Basic Coverage', 'Standard Support', '100 Points/Month'] },
                                { tier: 'Silver', color: 'gray', perks: ['Enhanced Coverage', 'Priority Support', '250 Points/Month'] },
                                { tier: 'Gold', color: 'yellow', perks: ['Premium Coverage', 'Dedicated Support', '500 Points/Month'] },
                                { tier: 'Platinum', color: 'purple', perks: ['Ultimate Coverage', 'VIP Support', '1000 Points/Month'] }
                            ].map((membership) => (
                                <div key={membership.tier} className={`bg-white rounded-xl p-6 border-2 ${
                                    membership.tier === 'Gold' ? 'border-yellow-400 ring-4 ring-yellow-100' : 'border-gray-200'
                                }`}>
                                    <div className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mb-4 ${
                                        membership.color === 'amber' ? 'bg-amber-100 text-amber-800' :
                                        membership.color === 'gray' ? 'bg-gray-100 text-gray-800' :
                                        membership.color === 'yellow' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-purple-100 text-purple-800'
                                    }`}>
                                        {membership.tier}
                                    </div>
                                    
                                    <ul className="space-y-2">
                                        {membership.perks.map((perk, idx) => (
                                            <li key={idx} className="flex items-center text-sm text-gray-600">
                                                <span className="text-green-500 mr-2">✓</span>
                                                {perk}
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                <section className="py-20 bg-blue-600">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h2 className="text-3xl lg:text-4xl font-bold text-white mb-6">
                            Ready to Get Protected & Rewarded?
                        </h2>
                        <p className="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                            Join thousands of satisfied members who trust us with their insurance needs and lifestyle benefits.
                        </p>
                        
                        {auth?.user ? (
                            <Link href="/dashboard">
                                <Button size="lg" className="bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-4">
                                    🚀 Access Your Dashboard
                                </Button>
                            </Link>
                        ) : (
                            <Link href="/register">
                                <Button size="lg" className="bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-4">
                                    🎯 Start Your Free Membership
                                </Button>
                            </Link>
                        )}
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-gray-900 text-gray-300 py-12">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid md:grid-cols-4 gap-8">
                            <div>
                                <div className="flex items-center space-x-2 mb-4">
                                    <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                        <span className="text-white font-bold text-sm">IM</span>
                                    </div>
                                    <span className="text-xl font-bold text-white">InsureMember</span>
                                </div>
                                <p className="text-sm text-gray-400 leading-relaxed">
                                    Your trusted partner for comprehensive insurance protection and lifestyle benefits.
                                </p>
                            </div>
                            
                            <div>
                                <h3 className="font-semibold text-white mb-4">Services</h3>
                                <ul className="space-y-2 text-sm">
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Auto Insurance</a></li>
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Health Insurance</a></li>
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Home Insurance</a></li>
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Dental Care</a></li>
                                </ul>
                            </div>
                            
                            <div>
                                <h3 className="font-semibold text-white mb-4">Support</h3>
                                <ul className="space-y-2 text-sm">
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Help Center</a></li>
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Contact Us</a></li>
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Claims Support</a></li>
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Member Portal</a></li>
                                </ul>
                            </div>
                            
                            <div>
                                <h3 className="font-semibold text-white mb-4">Company</h3>
                                <ul className="space-y-2 text-sm">
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">About Us</a></li>
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Careers</a></li>
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Press</a></li>
                                    <li><a href="#" className="hover:text-blue-400 transition-colors">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div className="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                            <p>&copy; 2024 InsureMember. All rights reserved. Protecting what matters most to you.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}
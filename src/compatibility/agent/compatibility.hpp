/*
 SPDX-FileCopyrightText: © 2020 Siemens AG

 SPDX-License-Identifier: GPL-2.0-only
*/

#ifndef COMPATIBILITY_AGENT_COMPATIBILITY_HPP
#define COMPATIBILITY_AGENT_COMPATIBILITY_HPP

#include <iostream>
#include "yaml-cpp/yaml.h"
#include "json/json.h"
#include <fstream>
#include <tuple>
#include <sstream>

#include "CompatibilityAgent.hpp"
#include "CompatibilityUtils.hpp"

extern "C" {
#include "libfossagent.h"
}

using namespace std;
vector<tuple<string, string, string>> compatibilityFunc(vector<string> myVec,
                                                        const string& lic_types,
                                                        const string& rule);

#endif // COMPATIBILITY_AGENT_OJOS_HPP
